<?php 
namespace Meteorlxy\LaravelWechat\Message\Handler;

use Illuminate\Http\Request;
use Meteorlxy\LaravelWechat\Foundation\WechatComponent;

class Handler {

	use WechatComponent;

	protected $request;

	protected $message;

	public function _init() {
		$this->request = Request::capture();
	}

	public function handle() {
		if(!$this->isFromWechat()) {
			return false;
		}

		$this->message = $this->parseXML($this->request->getContent());

		$response = new \SimpleXMLElement($this->message);
		$temp = $response->ToUserName;
		$response->ToUserName = $response->FromUserName;
		$response->FromUserName = $temp;

		return $response->asXML();

		switch($this->message->msgType) {

		}
	}

	public function isFromWechat() {
		$signature_check = [
            $this->wechat->config('token'), 
            $this->request->timestamp, 
            $this->request->nonce
        ];

        sort($signature_check);
        $signature_check = implode($signature_check);
        $signature_check = sha1($signature_check);

        return $signature_check == $this->request->signature;
	}

	public function parseXML($xml) {
		$result = simplexml_load_string($xml, 'SimpleXMLElement',  LIBXML_NOCDATA | LIBXML_NOBLANKS);
		if (false === $result) {
			return false;
		}
		return $result;
	}

	
}