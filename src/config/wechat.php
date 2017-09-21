<?php

return [

    'debug'     => env('WECHAT_DEBUG', false),
    'lang'      => env('WECHAT_LANG', 'zh_CN'),

    'server'    => env('WECHAT_SERVER', 'https://api.weixin.qq.com'),   // https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1465199793_BqlKA
    'timeout'   => env('WECHAT_TIMEOUT', 10),

    'token'     => env('WECHAT_TOKEN', 'your-token'),                   // Token
    'aes_key'   => env('WECHAT_AES_KEY', ''),                           // EncodingAESKey

    'appid'     => env('WECHAT_APPID', 'your-app-id'),                  // AppID
    'appsecret' => env('WECHAT_APPSECRET', 'your-app-secret'),          // AppSecret
    'expiration_margin' => env('WECHAT_EXPIRATION_MARGIN', 1200),       // How long before expiration to refresh access token
    
    'oauth2' => [
        'verify' => env('WEHCAT_OAUTH2_VERIFY', null),
        'state'  => env('WEHCAT_OAUTH2_STATE', 'laravel-wechat'),
    ],
];
