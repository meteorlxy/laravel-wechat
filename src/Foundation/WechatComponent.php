<?php
namespace Meteorlxy\LaravelWechat\Foundation;

use Meteorlxy\LaravelWechat\WechatApplication;

trait WechatComponent {
    /**
     * The WechatApplication instance
     *
     * @var \Meteorlxy\LaravelWechat\WechatApplication
     */
    protected $wechat;

    /**
     * Construct function. Set the WechatApplication instance
     *
     * @return void
     */
    public function __construct(WechatApplication $wechat) {
        $this->wechat = $wechat;
        $this->_init();
    }

    /**
     * Initialize function, which will be invoked after __construct()
     *
     * @return void
     */
    protected function _init() {}

}