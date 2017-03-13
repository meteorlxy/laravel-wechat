<?php 
namespace Meteorlxy\LaravelWechat;

use Illuminate\Support\ServiceProvider;

class WechatServiceProvider extends ServiceProvider {

    /**
	 * Bootstrap the application.
	 *
	 * @return void
	 */
	public function boot()
	{
	    $this->publishes([
            __DIR__.'/config/wechat.php' => config_path('wechat.php'),
	    ]);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		
		$this->app->singleton('wechat', function($app) {
			 $wechat = new WechatApplication(config('wechat'));

			 // Foundation - WechatHttpClient
			 $wechat->singleton('httpClient', function($wechat) {
				return new Foundation\WechatHttpClient($wechat);
			 });

			 // Foundation - AccessToken
			 $wechat->singleton('accessToken', function($wechat){
				return new Foundation\AccessToken($wechat);
			 });

			 // API - Menu
			 $wechat->singleton('menu', function($wechat){
				return new API\Menu\Menu($wechat);
			 });

			 $wechat->singleton('handler', function($wechat){
				return new Message\Handler\Handler($wechat);
			 });
			 
			 return $wechat;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['wechat'];
	}
}