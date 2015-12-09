<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use \Auth;

class AuthController extends Controller
{

	public function index(Request $request)
	{
		return view('auth.login')
				->with([
					'referer' => $request->input('ref'),	
					'route' => $request->input('route'),	
				]);
	}
	
	public function login(Requests\LoginFormRequest $request)
	{
		$credentials = $request->only('email', 'password');
		$remember = $request->input('remember_me');

		if(Auth::attempt($credentials, $remember))
		{
			if($request->input('ref') == "admin" && Auth::user()->isAdmin())
			{
				$route = '';
				if($request->input('route'))
				{
					$route = '#' . $request->input('route');
				}
				
				return redirect('admin' . $route);	
			}
			
			return redirect('/');
		}

		return redirect('/auth/login')
					// ->with([
					// 	'referer' => $request->input('ref'),	
					// 	'route' => $request->input('route'),	
					// ])
			  		->withInput($request->only('email', 'remember_me'))
			  		->withErrors([
			  			'Kirjautuminen annetuilla tunnuksilla ei onnistunut!'
			  		]);
	}
	
	public function ajax_login(Request $request)
	{
		// if(Auth::check())
		// {
		// 	return [
		// 		'success' 	=> true,
		// 		'user'		=> Auth::user(),
		// 		'isAdmin'	=> Auth::user()->isAdmin(),
		// 	];
		// }
		
		$validation = \Validator::make($request->all(), [
			'email' => 'required',
			'password' => 'required',
		], [
			'email.required' 	=> 'Sähköpostiosoite puuttuu.',
			'email.email' 		=> 'Annettu sähköpostiosoite ei ole pätevä.',
			'password.required' => 'Salasana puuttuu.',
		]);
		
		if($validation->passes())
		{
			$credentials = [
				'email' 		=> $request->input('email'),
				'password'		=> $request->input('password'),
				'access_level'	=> 1,
			];
			$remember = $request->input('remember_me');

			if(Auth::attempt($credentials, $remember))
			{
				return [
					'success' 	=> true,
					'user'		=> Auth::user(),
					'isAdmin'	=> Auth::user()->isAdmin(),
				];
			}
			else
			{
				return [
					'success' 	=> false,
					'errors'	=> [
						'Virheelliset tunnukset tai oikeudet.',
					],
				];
			}
		}
		
		return [
			'success'	=> false,
			'errors'	=> $validation->errors()->all(),
		];
	}
	
	public function logout()
	{
		Auth::logout();
		return redirect('/');
	}

}
