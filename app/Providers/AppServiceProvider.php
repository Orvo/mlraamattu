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
			$result = false;
			
			if(Auth::check())
			{
				$result = Hash::check($value, Auth::user()->password);
			}
			
			if(count($parameters) == 1 && $parameters[0] == 'false')
			{
				return !$result;
			}
			
			return $result;
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
