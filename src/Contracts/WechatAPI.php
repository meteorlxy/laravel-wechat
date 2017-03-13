<?php
namespace Meteorlxy\LaravelWechat\Contracts;

interface WechatAPI {

    /**
     * Send request to the client
     *
     * @param  string   $method
     * @param  string   $url
     * @param  array    $options
     * @return string
     */
    public function request($method, $url, $options);

}