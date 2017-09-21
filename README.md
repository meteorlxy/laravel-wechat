# Laravel 微信开发包

个人边学习边开发的Wechat SDK for Laravel

还远远没有完成

部分内容参考自[overtrue/wechat](https://github.com/overtrue/wechat) 和 [overtrue/laravel-wechat](https://github.com/overtrue/laravel-wechat)

---

## 使用说明

1. 使用Composer引入

```bash
composer require meteorlxy/laravel-wechat
```

2. 注册ServiceProvider

在```config/app.php```中加入

```php
'providers' => [
    ...
    Meteorlxy\LaravelWechat\WechatServiceProvider::class,
]
```

3. 配置文件

运行以下命令，将在```config/```文件夹下生成```wechat.php```文件

```bash
php artisan vendor:publish
```

可以直接修改```wechat.php```，也可以在```.env```中添加如下变量覆盖默认配置
```
WECHAT_APPID
WECHAT_APPSECRET
WECHAT_TOKEN
WECHAT_AES_KEY
WECHAT_SERVER
WECHAT_TIMEOUTE
```

4. 使用


```php
<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use Meteorlxy\LaravelWechat\Controllers\WechatController as BaseController;

class WechatController extends BaseController
{
    public function listen() {
        $this->wechat->server->setHandler('text', function($message) {
            return [
                'Content' => '文字消息',
                // 若不设置FromUserName和ToUserName，默认回复给消息来源用户
                'FromUserName' => $message->ToUserName,
                'ToUserName' => $message->FromUserName,
            ];
        });
        
        $this->wechat->server->setHandler('event', function($message) {
            return [
                'Content' => '事件消息',
            ];
        });
        
        $this->wechat->server->setHandler('image', function($message) {
            return [
                'Content' => '图片消息',
            ];
        });
        
        $this->wechat->server->setHandler('voice', function($message) {
            return [
                'Content' => '语音消息',
            ];
        });
        
        $this->wechat->server->setHandler('video', function($message) {
            return [
                'Content' => '视频消息',
            ];
        });
        
        $this->wechat->server->setHandler('shortvideo', function($message) {
            return [
                'Content' => '小视频消息',
            ];
        });
        
        $this->wechat->server->setHandler('location', function($message) {
            return [
                'Content' => '地理位置消息',
            ];
        });
        
        $this->wechat->server->setHandler('link', function($message) {
            return [
                'Content' => '链接消息',
            ];
        });
        
        $this->wechat->server->setDefaultHandler(function($message) {
            return [
                'Content' => '默认处理器',
            ];
        });

        return $this->wechat->server->handle($request);
    }
}
        
```
