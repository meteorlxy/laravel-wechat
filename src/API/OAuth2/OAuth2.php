<?php
namespace Meteorlxy\LaravelWechat\API\OAuth2;

use Meteorlxy\LaravelWechat\API\WechatAPI;

class OAuth2 extends WechatAPI {
    protected $url = [
        'accessToken'        => 'sns/oauth2/access_token',
        'userinfo'           => 'sns/userinfo',
    ];
    
    public function getAuthorizeUrl(string $redirect_uri, bool $userinfo = false, string $state = '') {
        $url = 
          'https://open.weixin.qq.com/connect/oauth2/authorize'
          . '?appid=' . $this->wechat->config('appid')
          . '&redirect_uri=' . urlencode($redirect_uri)
          . '&response_type=code&scope=' . ($userinfo ? 'snsapi_userinfo' : 'snsapi_base')
          . '&state=' . ( $state === '' ? $this->wechat->config('oauth2.state') : $state)
          . '#wechat_redirect';
        
        return $url;
    }
    
    public function accessToken($code) {
        return $this->request(
            'GET',
            $this->url[__FUNCTION__],
            null,
            [
                'query' => [
                    'appid' => $this->wechat->config('appid'),
                    'secret' => $this->wechat->config('appsecret'),
                    'code' => $code,
                    'grant_type' => 'authorization_code',
                ],
            ],
            false
        );
    }

    public function userinfo($access_token, $openid) {
        return $this->request(
            'GET',
            $this->url[__FUNCTION__],
            null,
            [
                'query' => [
                    'access_token' => $access_token,
                    'openid' => $openid,
                    'lang' => $this->wechat->config('lang'),
                ],
            ],
            false
        );
    }
}