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

    /**
     * Parse the JSON response from server
     *
     * @param  string|\GuzzleHttp\Psr7\Response   $response
     * @return array
     * @throws \Meteorlxy\LaravelWechat\Exceptions\WechatHttpException
     */
    public function parseResponse($response);

}