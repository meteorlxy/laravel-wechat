<?php
namespace Meteorlxy\LaravelWechat\API\Contracts;

use Meteorlxy\LaravelWechat\AccessToken\AccessToken;

abstract class WechatAPI {
    // URL of API
    protected $url;

    // Access Token
    protected $access_token;

    // Request Method
    protected $method;

    public function __construct(AccessToken $accessToken) {
        $this->setAccessToken($accessToken);
    }

    public function parseJSON() {
        
    }

}