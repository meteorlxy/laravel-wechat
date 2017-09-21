<?php
namespace Meteorlxy\LaravelWechat\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Meteorlxy\LaravelWechat\Foundation\WechatComponent;

class WechatController extends Controller 
{
    use WechatComponent;

    public function listen(Request $request) {
        return $this->wechat->server->handle($request);
    }
}
