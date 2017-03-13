<?php

return [

    'debug'     => true,

    'server'    => env('WECHAT_SERVER', 'https://api.weixin.qq.com'),
    'timeout'   => env('WECHAT_TIMEOUT', 10),

    'appid'     => env('WECHAT_APPID', ''),         // AppID
    'appsecret' => env('WECHAT_APPSECRET', ''),     // AppSecret
    'token'     => env('WECHAT_TOKEN', ''),         // Token
    'aes_key'   => env('WECHAT_AES_KEY', ''),       // EncodingAESKey

];
