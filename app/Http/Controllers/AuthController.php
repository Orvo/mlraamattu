<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

	public function index()
	{
		return view('auth.login');
	}
	
	public function login(Requests\LoginFormRequest $request)
	{
		$credentials = $request->only('email', 'password');

		if(\Auth::attempt($credentials))
		{
			return redirect('/');
		}

		return 'Login fail';
	}
	
	public function logout()
	{
		\Auth::logout();	
	}

}
