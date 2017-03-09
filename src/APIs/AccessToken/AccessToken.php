<?php
namespace Meteorlxy\LaravelWechat\AccessToken;
use Cache;

class AccessToken {
    protected $request_url = 'https://api.weixin.qq.com/cgi-bin/token';
    protected $grant_type  = 'client_credential';
    protected $appid;
    protected $appsecrect;
    protected $token;

    public function __construct($config) {
        $this->appid = $config['appid'];
        $this->appsecrect = $config['appsecrect'];
        $this->token = $config['token'];
    }

    public function getAccessToken() {
        
    }

    public function updateAccessToken() {
        $params = [
            'grant_type'    => $this->grant_type,
            'appid'         => $this->appid,
            'secret'        => $this->appsecret,
        ];

        $curl_options = [
            CURLOPT_URL             => 'https://api.weixin.qq.com/cgi-bin/token?grant_type='.$this->grant_type.'&appid=' . $this->appid . '&secret=' . $this->appsecret,
            CURLOPT_POST            => false,    // true: 发送post请求
            CURLOPT_HEADER          => false,   // true: 将头文件的信息作为数据流输出。
            CURLOPT_RETURNTRANSFER  => true,    // true：将curl_exec()获取的信息以字符串返回，而不是直接输出。 
        ];

        
        $curl_handler = curl_init();                        // 初始化curl会话并返回句柄
        curl_setopt_array($curl_handler, $curl_options);    // 为curl会话配置参数
        $curl_result = curl_exec($curl_handler);            // 执行curl会话，获取返回值
        if (false === $curl_result) {
            Log::warning('[Wechat] Failed to update access_token. errno:'.curl_errno($curl_handler).', error:'.curl_error($curl_handler));
            curl_close($curl_result);                       // 关闭curl会话并删除句柄
            return false;
        } else {
            $result = json_decode($curl_result, true);      // true时生成array
            $update = AccessToken::first()
                        ->update([
                            'access_token' => $result['access_token'],                              // 更新access_token
                            'expired_at' => date('Y-m-d H:i:s', time() + $result['expires_in']),    // 计算并更新expired_at
                        ]);
            if (false === $update) {
                Log::warning('[Wechat] Failed to write DB when updating access_token.');
            } else {
                Log::info('[Wechat] Update access_token successfully. Expiration: '.$expired_at);
            }
        }
    }

}