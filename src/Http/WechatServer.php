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

    protected $handler;

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

        // 调用处理message的handler并返回处理后的响应消息
        $response = $this->handleMessage($message);
        
        return new Response($response);
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
        
        if (!isset($this->handler) || !is_callable($this->handler)) {
            return 'success';
        }
        
        $result = call_user_func_array($this->handler, [$message]);
        
        if (is_string($result)) {
            $result = [
                'Content' => $result,
                'MsgType' => 'text',
            ];
        }
        
        if (is_array($result)) {
            if (!array_key_exists('FromUserName', $result)) {
                $result['FromUserName'] = $message['ToUserName'];
            }
            if (!array_key_exists('ToUserName', $result)) {
                $result['ToUserName'] = $message['FromUserName'];
            }
            $replyMessage = Message::make($result);
        } elseif ($result instanceof Message) {
            $replyMessage = $result;
        } else {
            return 'success';
        }

        return $replyMessage->toXML();
    }

    public function setHandler($callback) {
        if (is_callable($callback)) {
            $this->handler = $callback;
        } else {
            throw new WechatException('The handler must be callable');
        }
    }

}