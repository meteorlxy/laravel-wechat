<?php
namespace Meteorlxy\LaravelWechat\Http;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Meteorlxy\LaravelWechat\Message\Message;
use Meteorlxy\LaravelWechat\Support\ExSimpleXMLElement;
use Meteorlxy\LaravelWechat\Foundation\WechatComponent;
use Meteorlxy\LaravelWechat\Exceptions\Http\WechatHttpException;
use Meteorlxy\LaravelWechat\Contracts\Message\Message as MessageContract;
use Meteorlxy\LaravelWechat\Contracts\Http\WechatServer as WechatServerContract;

class WechatServer implements WechatServerContract {

    use WechatComponent;

    protected $handlers = [];
    protected $defaultHandlers;

    /**
     * Handle the request
     *
     * @param \Illuminate\Http\Request   $request
     * @return \Illuminate\Http\Response 
     */
    public function handle(Request $request) {

        if (!$this->wechat->config('debug') && !$this->isSignatureValid($request)) {
            return new Response('403 Forbidden. Signature Invalid', 403);
        }

        if ($request->has('echostr')) {
            return new Response($request->echostr, 200);
        }
        
        $requestMessage = $this->getRequestMessage($request);

        if (false === $requestMessage) {
            return new Response('400 Bad Request', 400);
        }

        $handleResult = $this->handleMessage($requestMessage);

        if (!is_array($handleResult)) {
            return new Response('success');
        }

        $responseMessage = $this->makeResponseMessage($handleResult);

        return new Response($responseMessage->toXML());
    }

    /**
     * Check if the request is from Wechat server
     *
     * @param \Illuminate\Http\Request   $request
     * @return bool
     */
    public function isSignatureValid(Request $request) {
		$signature_check = [
            $this->wechat->config('token'), 
            $request->timestamp, 
            $request->nonce
        ];

        sort($signature_check);
        $signature_check = implode($signature_check);
        $signature_check = sha1($signature_check);

        return $signature_check == $request->signature;
	}

    /**
     * Parse the XML request and get the message
     *
     * @param \Illuminate\Http\Request   $request
     * @return \Meteorlxy\LaravelWechat\Contracts\Message\Message
     */
    public function getRequestMessage(Request $request) {
        $content = $request->getContent();
        $simplexml = simplexml_load_string($content, ExSimpleXMLElement::class,  LIBXML_NOCDATA | LIBXML_NOBLANKS);
		if (false === $simplexml) {
			return false;
		}
        return new Message($simplexml);
    }

    /**
     * Handle the message from the request and return the handle result
     *
     * @param \Meteorlxy\LaravelWechat\Contracts\Message\Message   $requestMessage
     * @return mixed
     */
    public function handleMessage(MessageContract $message) {
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

    /**
     * Make message from handle result for response
     *
     * @param mixed   $handleResult
     * @return \Illuminate\Http\Response
     */
    public function makeResponseMessage($handleResult) {

        $responseMessage = Message::make($handleResult);

        if (!$responseMessage->isValid()) {
            return 'success';
        }

        return $responseMessage;
    }

    /**
     * Set the message handler for specific message type
     *
     * @param string   $msgtype
     * @param callable $callback
     * @return void
     *
     * @throws \Meteorlxy\LaravelWechat\Exceptions\WechatHttpException
     */
    public function setHandler($msgtype, $callback) {
        if (is_callable($callback)) {
            $this->handlers[$msgtype] = $callback;
        } else {
            throw new WechatHttpException('The handler of ['.$msgtype.'] must be callable');
        }
    }

    /**
     * Set the default message handler for messages whose handlers are not set with setHandler()
     *
     * @param callable $callback
     * @return void
     *
     * @throws \Meteorlxy\LaravelWechat\Exceptions\WechatHttpException
     */
    public function setDefaultHandler($callback) {
        if (is_callable($callback)) {
            $this->defaultHandler = $callback;
        } else {
            throw new WechatHttpException('The default handler must be callable');
        }
    }
}