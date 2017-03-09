<?php

return [

    'debug'     => true,

    'appid'     => env('WECHAT_APPID', 'your-app-id'),          // AppID
    'appsecret' => env('WECHAT_APPSECRET', 'your-app-secret'),  // AppSecret
    'token'     => env('WECHAT_TOKEN', 'your-token'),           // Token
    'aes_key'   => env('WECHAT_AES_KEY', ''),                   // EncodingAESKey

];
