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
		$this->app->singleton('wechat', function()
		{
			return new WechatApplication(config('wechat'));
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