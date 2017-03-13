<?php 
namespace Meteorlxy\LaravelWechat;

use Illuminate\Container\Container;

class WechatApplication extends Container{

	protected $config;

	public function __construct(array $config) {
		$this->config = $config;
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