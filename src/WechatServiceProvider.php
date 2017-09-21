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
				 return new WechatApplication($app->config['wechat']);
			});
			$this->app->alias('wechat', WechatApplication::class);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [
			'wechat',
			WechatApplication::class,
		];
	}
}