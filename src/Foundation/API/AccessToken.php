<?php
namespace Meteorlxy\LaravelWechat\Foundation\API;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Meteorlxy\LaravelWechat\Exceptions\WechatException;
use Meteorlxy\LaravelWechat\Contracts\Foundation\AccessToken as AccessTokenContract;

class AccessToken implements AccessTokenContract {
    use WechatComponent;

    /**
     * The url of get access_token
     *
     * @var string
     */
    protected $url = 'cgi-bin/token';

    /**
     *  The Cached key of access_token
     *
     * @var string
     */
    protected $key = 'wechat.access_token';
    protected $key_backup = 'wechat.access_token.backup';

    /**
     * Get the access token from Cache
     *
     * @return string
     *
     * @throws \Meteorlxy\LaravelWechat\Exceptions\WechatException
     */
    public function get() {
        if (!Cache::has($this->key_backup)) {
            throw new WechatException('Access token unavailable');
        }

        return Cache::get($this->key_backup);
    }

    /**
     * Update the access token
     *
     * @param  bool     $isForced
     * @return bool
     */
    public function update($isForced = false) {
        if (!$isForced && Cache::has($this->key)) {
            return true;
        }

        $params = [
            'grant_type' => 'client_credential',
            'appid' => $this->wechat->config('appid'),
            'secret' => $this->wechat->config('appsecret'),
        ];

        $response = $this->wechat->httpClient->request('GET', $this->url ,[
            'query' => $params
        ]);

        $access_token = $response['access_token'];
        $expiration_backup = Carbon::now()->addSeconds($response['expires_in']);
        $expiration = $expiration_backup->subSeconds($this->wechat->config('expiration_margin'));

        Cache::put($this->key_backup, $access_token, $expiration_backup);
        Cache::put($this->key, $access_token, $expiration);

        return true;
    }

}