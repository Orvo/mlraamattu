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
				]);
	}
	
	public function login(Requests\LoginFormRequest $request)
	{
		$credentials = $request->only('email', 'password');

		if(Auth::attempt($credentials))
		{
			if($request->input('ref') == "admin" && Auth::user()->isAdmin())
			{
				return redirect()->intended('admin');	
			}
			
			return redirect('/');
		}

		return redirect('/auth/login')
			  		->withInput($request->only('email', 'remember_me', 'ref'))
			  		->withErrors([
			  			'Kirjautuminen annetuilla tunnuksilla ei onnistunut!'
			  		]);
	}
	
	public function logout()
	{
		Auth::logout();
		return redirect('/');
	}

}
