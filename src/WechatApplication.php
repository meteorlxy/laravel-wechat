<?php 
namespace Meteorlxy\LaravelWechat;

use Illuminate\Config\Repository;
use Illuminate\Container\Container;

class WechatApplication extends Container {

	public function __construct(array $config) {
			$this->setConfig($config);
			$this->registerService();
	}
	
	protected function setConfig($config) {
			$this->instance('config', new Repository($config));
	}

	public function config($key) {
			return $this->config[$key];
	}

	protected function registerService() {
		// Http - WechatClient
		$this->singleton('client', function($wechat) {
			return new Http\WechatClient($wechat);
		});

		// Http - WechatServer
		$this->singleton('server', function($wechat) {
			return new Http\WechatServer($wechat);
		});

		// Message
		$this->singleton('message', function($wechat){
			return new Message\Message($wechat);
		});

		// API - Foundation - AccessToken
		$this->singleton('accessToken', function($wechat){
			return new Foundation\API\AccessToken($wechat);
		});

		// API - Menu
		$this->singleton('menu', function($wechat){
			return new API\Menu\Menu($wechat);
		});

		// API - OAuth2
		$this->singleton('oauth2', function($wechat){
			return new API\OAuth2\OAuth2($wechat);
		});

		// API - Template
		$this->singleton('template', function($wechat){
			return new API\Template\Template($wechat);
		});
	}

}