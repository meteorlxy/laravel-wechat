<?php
namespace Meteorlxy\LaravelWechat\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatController extends Controller {

    protected $wechat;

    public function __construct() {
        $this->wechat = $wechat = resolve('wechat');
    }

    public function checkSignature(Request $request) {

		$signature_check = [
            $this->wechat->config('token'), 
            $request->timestamp, 
            $request->nonce
        ];

        sort($signature_check);
        $signature_check = implode($signature_check);
        $signature_check = sha1($signature_check);

        if ($signature_check == $request->signature) {
            return $request->echostr;
        } else {
            return response('invalid', 403);
        }
	}
}
