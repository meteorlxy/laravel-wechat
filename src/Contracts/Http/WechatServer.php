<?php
namespace Meteorlxy\LaravelWechat\Contracts\Http;

use Illuminate\Http\Request;
use Meteorlxy\LaravelWechat\Contracts\Message\Message as MessageContract;

interface WechatServer {

    /**
     * Handle the request
     *
     * @param \Illuminate\Http\Request   $request
     * @return \Illuminate\Http\Response 
     */
    public function handle(Request $request);

    /**
     * Check if the request is from Wechat server
     *
     * @param \Illuminate\Http\Request   $request
     * @return bool
     */
    public function isSignatureValid(Request $request);

    /**
     * Parse the XML request and get the message
     *
     * @param \Illuminate\Http\Request   $request
     * @return \Meteorlxy\LaravelWechat\Contracts\Message\Message
     */
    public function getRequestMessage(Request $request);

    /**
     * Handle the message from the request and return the handle result
     *
     * @param \Meteorlxy\LaravelWechat\Contracts\Message\Message   $requestMessage
     * @return mixed
     */
    public function handleMessage(MessageContract $requestMessage);

    /**
     * Make message from handle result for response
     *
     * @param mixed   $handleResult
     * @return \Illuminate\Http\Response
     */
    public function makeResponseMessage($handleResult);

}