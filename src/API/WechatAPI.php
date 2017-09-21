<?php
namespace Meteorlxy\LaravelWechat\API;

use Meteorlxy\LaravelWechat\Foundation\WechatComponent;
use Meteorlxy\LaravelWechat\Contracts\API\WechatAPI as WechatAPIContract;

abstract class WechatAPI implements WechatAPIContract{

    use WechatComponent;

    /**
     * Send request to the client
     *
     * @param  string   $method
     * @param  string   $url
     * @param  array    $options
     * @return \Illuminate\Support\Collection
     */
    public function request($method, $url, $data = null, $options = [], $inject_access_token = true) {

        $method = strtoupper($method);

        if (null !== $data) {
            $options['body'] = json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        
        // add the access_token into the query string
        if ($inject_access_token) {
            $options['query']['access_token'] = $this->wechat->accessToken->get();
        }

        // return the Collection of response from the httpClient
        return collect($this->wechat->client->request($method, $url, $options));
    }

}