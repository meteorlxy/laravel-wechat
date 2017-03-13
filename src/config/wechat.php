<?php

return [

    'debug'     => env('WECHAT_DEBUG', false),

    'server'    => env('WECHAT_SERVER', 'https://api.weixin.qq.com'),
    'timeout'   => env('WECHAT_TIMEOUT', 10),

    'token'     => env('WECHAT_TOKEN', 'your-token'),           // Token
    'aes_key'   => env('WECHAT_AES_KEY', ''),                   // EncodingAESKey

    /**
     *  Access Token
     */
    'appid'     => env('WECHAT_APPID', 'your-app-id'),              // AppID
    'appsecret' => env('WECHAT_APPSECRET', 'your-app-secret'),      // AppSecret
    'expiration_margin' => env('WECHAT_EXPIRATION_MARGIN', 1200),   // How long before expiration to refresh access token

];
