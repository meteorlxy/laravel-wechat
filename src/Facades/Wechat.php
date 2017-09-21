<?php 

namespace Meteorlxy\LaravelWechat\Facades;

use Illuminate\Support\Facades\Facade;

class Wechat extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { 
	    return 'wechat'; 
	}

}