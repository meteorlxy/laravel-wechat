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

随时可以通过```resolve('wechat')```获取实例，可以参考```src/Controllers/WechatController```中的写法

> 注意：接收微信服务器消息的路由应写在```routes/api.php```下
