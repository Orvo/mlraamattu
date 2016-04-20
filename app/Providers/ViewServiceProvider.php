<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

use App\Contentpage;

class ViewServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot(Request $request)
	{
		if($this->app->runningInConsole()) return false;
		if($request->isXmlHttpRequest() || $request->ajax() || $request->wantsJson()) return false;
		
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
