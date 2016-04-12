<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contentpage;

class ViewServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$content_pages = Contentpage::pinned()->get();
		view()->share('content_pages', $content_pages);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
