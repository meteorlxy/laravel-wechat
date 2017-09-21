<?php
namespace Meteorlxy\LaravelWechat\Http;

use SimpleXMLElement;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Meteorlxy\LaravelWechat\Message\Message;
use Meteorlxy\LaravelWechat\Foundation\WechatComponent;
use Meteorlxy\LaravelWechat\Exceptions\WechatException;
use Meteorlxy\LaravelWechat\Exceptions\Http\WechatHttpException;
use Meteorlxy\LaravelWechat\Contracts\Http\WechatServer as WechatServerContract;

class WechatServer implements WechatServerContract {

    use WechatComponent;

    protected $middleware;
    protected $handlers = [];
    protected $defaultHandlers;

    public function handle(Request $request) {

        // 检查Signature，DEBUG模式下不用检查
        if (!$this->wechat->config('debug') && $this->isSignatureInvalid($request)) {
            return new Response('403 Forbidden. Signature Invalid', 403);
        }

        // 若存在echostr，原样返回
        if ($request->has('echostr')) {
            return new Response($request->echostr);
        }

        // 获取请求中的message信息
        $message = $this->getMessageFromRequest($request);

        // 若获取message失败
        if (false === $message) {
            return new Response('400 Bad Request', 400);
        }

        // 调用处理message的handler
        $reply = $this->handleMessage($message);

        // 生成返回的message
        if (is_array($reply)) {
            if (!array_key_exists('FromUserName', $reply)) {
                $reply['FromUserName'] = $message->ToUserName;
            }
            if (!array_key_exists('ToUserName', $reply)) {
                $reply['ToUserName'] = $message->FromUserName;
            }
            $replyMessage = Message::make($reply);
        } elseif ($reply instanceof Message) {
            $replyMessage = $reply;
        } else {
            throw new WechatException('The return value of handlers must be an array of an instance of Meteorlxy\LaravelWechat\Message\Message');
        }
        
        return new Response($replyMessage->toXML());
    }

    public function isSignatureInvalid(Request $request) {
		$signature_check = [
            $this->wechat->config('token'), 
            $request->timestamp, 
            $request->nonce
        ];

        sort($signature_check);
        $signature_check = implode($signature_check);
        $signature_check = sha1($signature_check);

        return $signature_check !== $request->signature;
	}

    public function getMessageFromRequest(Request $request) {
        $content = $request->getContent();
        return Message::fromXML($content);
    }

    public function handleMessage($message) {
        $msgtype = $message->MsgType;
        
        if (isset($this->handlers[$msgtype]) && is_callable($this->handlers[$msgtype])) {
            $handler = $this->handlers[$msgtype];
        } elseif (isset($this->defaultHandler) && is_callable($this->defaultHandler)) {
            $handler = $this->defaultHandler;
        } else {
            return null;
        }

        return call_user_func_array($handler, [$message]);
    }

    public function setHandler($msgtype, $callback) {
        if (is_callable($callback)) {
            $this->handlers[$msgtype] = $callback;
        } else {
            throw new WechatException('The handler of ['.$msgtype.'] must be callable');
        }
    }

    public function setDefaultHandler($callback) {
        if (is_callable($callback)) {
            $this->defaultHandler = $callback;
        } else {
            throw new WechatException('The default handler must be callable');
        }
    }
}