<?php
namespace Meteorlxy\LaravelWechat\Contracts\Http;

interface WechatClient {

    /**
     * Send request to the Wechat API server
     *
     * @param  string   $method
     * @param  string   $url
     * @param  array    $options
     * @return string
     * @throws \GuzzleHttp\Exception\TransferException
     */
    public function request($method, $url, $options);

}