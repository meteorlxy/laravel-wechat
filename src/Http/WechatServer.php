<?php
namespace Meteorlxy\LaravelWechat\Http;

use SimpleXMLElement;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Meteorlxy\LaravelWechat\Message\Message;
use Meteorlxy\LaravelWechat\Foundation\WechatComponent;
use Meteorlxy\LaravelWechat\Exceptions\Http\WechatHttpException;
use Meteorlxy\LaravelWechat\Contracts\Http\WechatServer as WechatServerContract;

class WechatServer implements WechatServerContract {

    use WechatComponent;

    protected $handlers = [];
    protected $defaultHandlers;

    public function handle(Request $request) {

        if (!$this->wechat->config('debug') && $this->isSignatureInvalid($request)) {
            return new Response('403 Forbidden. Signature Invalid', 403);
        }

        if ($request->has('echostr')) {
            return new Response($request->echostr, 200);
        }

        $message = $this->getMessageFromRequest($request);

        if (false === $message) {
            return new Response('400 Bad Request', 400);
        }

        $reply = $this->handleMessage($message);

        $replyMessage = Message::make($reply)->toXML();

        return new Response($replyMessage);
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

        return $signature_check != $request->signature;
	}

    public function getMessageFromRequest(Request $request) {
        $content = $request->getContent();
        $simplexml = simplexml_load_string($content, 'SimpleXMLElement',  LIBXML_NOCDATA | LIBXML_NOBLANKS);
		if (false === $simplexml) {
			return false;
		}
        return new Message($simplexml);
    }

    public function handleMessage($message) {
        $msgtype = $message->get('MsgType');

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
            throw new WechatHttpException('The handler of ['.$msgtype.'] must be callable');
        }
    }

    public function setDefaultHandler($callback) {
        if (is_callable($callback)) {
            $this->defaultHandler = $callback;
        } else {
            throw new WechatHttpException('The default handler must be callable');
        }
    }
}