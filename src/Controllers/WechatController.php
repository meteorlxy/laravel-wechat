<?php
namespace Meteorlxy\LaravelWechat\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatController extends Controller {

    /**
     * The WechatApplication instance
     *
     * @var \Meteorlxy\LaravelWechat\WechatApplication
     */
    protected $wechat;

    public function __construct() {
        $this->wechat = $wechat = resolve('wechat');
    }

    /**
     * Route the wechat url to this method (remember to route in /routes/api.php) | 将公众号配置中填写的URL路由到该方法（记得应写在/routes/api.php中）
     */
    public function main(Request $request) {
        $server = $this->wechat->server;
        $server->setDefaultHandler(
            function($message){
                $reply = [
                    'ToUserName' => $message->get('FromUserName'),
                    'FromUserName' => $message->get('ToUserName'),
                    'Content' => '你好，欢迎使用meteorlxy/laravel-wechat'
                ];
                return $reply;
            }
        );
        return $server->handle($request);
    }
}
