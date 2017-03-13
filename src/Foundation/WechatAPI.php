<?php
namespace Meteorlxy\LaravelWechat\Foundation;

use Meteorlxy\LaravelWechat\Contracts\WechatAPI as WechatAPIContract;

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
    public function request($method, $url, $data = null, $options = []) {

        $method = strtoupper($method);

        // if(is_array($data)) {
        //     $options['form_params'] = $data;
        // } else {
        //     $options['body'] = $data;
        // }
        if (null !== $data) {
            $options['body'] = json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        // add the access_token into the query string
        $options['query']['access_token'] = $this->wechat->accessToken->get();

        // return the Collection of response from the httpClient
        return collect($this->wechat->httpClient->request($method, $url, $options));
    }

}