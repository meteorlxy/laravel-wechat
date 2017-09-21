<?php
namespace Meteorlxy\LaravelWechat\Http;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Meteorlxy\LaravelWechat\Foundation\WechatComponent;
use Meteorlxy\LaravelWechat\Exceptions\Http\WechatHttpException;
use Meteorlxy\LaravelWechat\Contracts\Http\WechatClient as WechatClientContract;

class WechatClient implements WechatClientContract {

    use WechatComponent;

    /**
     * The GuzzleHttp\Client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    public function _init() {
        $this->client = new Client([
            'base_uri' => $this->wechat->config('server'),
            'timeout' => $this->wechat->config('timeout'),
        ]);
    }

    /**
     * Send request to the Wechat API server
     *
     * @param  string   $method
     * @param  string   $uri
     * @param  array    $options
     * @return array
     * @throws \GuzzleHttp\Exception\TransferException
     */
    public function request($method, $uri, $options = []) {
        
        $response = $this->client->request($method, $uri, $options);

        $response_log = [
            'StatusCode' => $response->getStatusCode(),
            'ReasonPhrase' => $response->getReasonPhrase(),
            'Headers' => $response->getHeaders(),
            'Body' => $response->getBody(),
        ];

        return $this->parseResponse($response);
    }


    /**
     * Parse the JSON response from server
     *
     * @param  string|\GuzzleHttp\Psr7\Response   $response
     * @return array
     * @throws \Meteorlxy\LaravelWechat\Exceptions\WechatHttpException
     */
    public function parseResponse($response) {
        if ($response instanceof ResponseInterface) {
            $response = $response->getBody();
        }
        
        $result = json_decode($response, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new WechatHttpException('Failed to parse JSON: ' . json_last_error_msg());
        }

        // if (isset($result['errcode']) && 0 !== $result['errcode']) {
        //     if (empty($result['errmsg'])) {
        //         $result['errmsg'] = 'unknown';
        //     }
        //     throw new WechatHttpException('Error from Wechat Server: ['.$result['errcode'].']'.$result['errmsg'], $result['errcode']);
        // }

        return $result;
    }

    public function __call($method, $parameters) {
        return $this->client->{$method}(...$parameters);
    }
}