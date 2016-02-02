<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use \Validator;
use \Auth;
use \Hash;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Validator::extend('match_password', function($attribute, $value, $parameters, $validator)
		{
			if(!Auth::check()) return false;
			
			return Hash::check($value, Auth::user()->password);
		});
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		if ($this->app->environment() == 'local') {
			$this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
		}
	}
}
