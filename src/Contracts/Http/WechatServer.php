<?php
namespace Meteorlxy\LaravelWechat\Contracts\Http;

use Illuminate\Http\Request;

interface WechatServer {

    /**
     * Handle the request
     */
    public function handle(Request $request);

    /**
     * Check if the request is from Wechat server
     */
    public function isSignatureInvalid(Request $request);

    /**
     * Parse the XML request and get the message
     */
    public function getMessageFromRequest(Request $request);

}