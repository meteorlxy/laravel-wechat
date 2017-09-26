<?php
namespace Meteorlxy\LaravelWechat\Contracts\Http;

use Illuminate\Http\Request;

interface WechatServer {

    /**
     * Handle the request
     */
    public function handle(Request $request);

}