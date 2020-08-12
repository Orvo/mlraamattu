<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AjaxAuthenticate
{
	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $role = false)
	{
		if (!$this->auth->check() or !$this->auth->user()->canAccessAjax())
		{
			return [
				'error' => 'Insufficient permissions',
			];
		}
		
		if($role && !$this->auth->user()->hasPermission($role))
		{
			return [
				'error' => 'Insufficient permissions',
			];
		}

		return $next($request);
	}
}
