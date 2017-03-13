<?php 
namespace Meteorlxy\LaravelWechat;

use Illuminate\Container\Container;

class WechatApplication extends Container{

	protected $config;

	public function __construct(array $config) {
		$this->config = $config;
		$this->registerService();
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
	}

	public function config($key) {
		return $this->config[$key];
	}

	public function __get($key) {
		return $this->offsetGet($key);
	}

	public function __set($key, $value) {
		return $this->offsetSet($key, $value);
	}
}