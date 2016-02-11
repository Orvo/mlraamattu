<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\LoginFormRequest;

use App\Http\Controllers\Controller;

use \Validator;

use \Auth;
use \Hash;


class AuthController extends Controller
{

	public function index(Request $request)
	{
		if(Auth::check())
		{
			return redirect('/');
		}
		
		return view('auth.login')
				->with([
					'referer' => $request->input('ref'),	
					'route' => $request->input('route'),	
				]);
	}
	
	public function login(LoginFormRequest $request)
	{
		if(Auth::check())
		{
			return redirect('/');
		}
		
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
	  		->withInput($request->only('email', 'remember_me'))
	  		->withErrors([
	  			'Kirjautuminen annetuilla tunnuksilla ei onnistunut!'
	  		]);
	}
	
	public function ajax_login(Request $request)
	{
		if(Auth::check())
		{
			return [
				'success' 	=> true,
				'user'		=> Auth::user(),
				'isAdmin'	=> Auth::user()->isAdmin(),
			];
		}
		
		$validation = Validator::make($request->all(), [
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

    public function edit()
    {
    	$user = Auth::user();
    	
    	return view('auth.edit', [
    		'user' => [
	    		'name' => $user->name,
	    		'email' => $user->email,
    		],
    	]);
    }
    
    public function save(Request $request)
    {
    	$user = Auth::user();
    	
		$validation = Validator::make($request->all(), [
			'name'				=> 'required',
			'email'				=> 'required|email|unique:users,email,' . $user->id,
			'current_password'	=> 'required_with:new_password|match_password',
			'new_password'		=> 'required_with:current_password|min:8|confirmed'
		],
		[
			'name.required'						=> 'Nimi on pakollinen.',
			'email.required'					=> 'Sähköpostiosoite on pakollinen.',
			'email.email'						=> 'Annettu sähköpostiosoite ei ole pätevä.',
			'email.unique'						=> 'Sähköpostiosoite on jo käytössä.',
			'current_password.match_password'	=> 'Nykyinen salasana ei täsmää.',
			'current_password.required_with'	=> 'Syötä nykyinen salasana.',
			'new_password.required_with'		=> 'Syötä uusi salasana.',
			'new_password.min'					=> 'Uuden salasanan pitää olla ainakin :min merkkiä pitkä.',
			'new_password.confirmed'			=> 'Uudet salasanat eivät täsmää.',
		]);
		
		if(!$validation->passes())
		{
	    	return view('auth.edit', [
	    		'user' => $request->only('name', 'email'),
	    	])
	    	->withErrors($validation);
		}
		else
		{
			$user->name = $request->get('name');
			$user->email = $request->get('email');
			
			if($request->has('new_password'))
			{
				$user->password = Hash::make($request->get('new_password'));
			}
			
			$user->save();
			
	    	return view('auth.edit', [
	    		'user' => $request->only('name', 'email'),
	    		'success' => true,
	    	]);
		}
    }
    
    public function reset()
    {
		if(Auth::check()) return redirect('/');
		
    	return view('auth.reset');
    }
    
    public function send_reset(Request $request)
    {
		if(Auth::check()) return redirect('/');
		
		$validation = Validator::make($request->all(), [
			'email'				=> 'required|email',
		],
		[
			'email.required'			=> 'Anna sähköpostiosoite.',
			'email.email'				=> 'Annettu sähköpostiosoite ei ole pätevä.',
			'email.email_exists'		=> 'Annettu sähköpostiosoite ei ole pätevä.',
		]);
		
		if(!$validation->passes())
		{
			return view('auth.reset',
				[
					'email' => $request->get('email'),
				])
				->withErrors($validation);
		}
		
    	return view('auth.reset_sent');
    }
    
}
