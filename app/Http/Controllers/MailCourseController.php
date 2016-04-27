<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Mail;

class MailCourseController extends Controller
{
	
	public function index()
	{
		return view('mailcourse.form');
	}
	
	public function submit(Request $request)
	{
		$validation = \Validator::make($request->all(), [
			'course' 	=> 'required',
			'name'		=> 'required',
			'address'	=> 'required',
			'city'		=> 'required',
			'phone'		=> 'min:5',
			'email'		=> 'email',
		],
		[
			'course.required' 	=> 'Kurssivalinta puuttuu',
			'name.required'		=> 'Nimi on pakollinen',
			'address.required'	=> 'Lähiosoite on pakollinen',
			'city.required'		=> 'Postinumero ja -toimipaikka on pakollinen',
			'phone.min'			=> 'Syötä oikea puhelinnumero',
			'email.email'		=> 'Sähköpostiosoite ei ole pätevä',
		]);
		
		if($validation->fails())
		{
			return redirect()->back()->withInput()->withErrors($validation);
		}
		
		$users = \App\User::where('access_level', 'ADMIN')->get();
		
		foreach($users as $user)
		{
			Mail::send('mailcourse.email',
			[
				'data'	=> $request->all()
			],
			function ($message) use ($user)
			{
				$message->to($user->email, $user->name);
				$message->subject('Kirjekurssin tilaus');
			
				$message->priority(2);
			});
		}
		
		return view('mailcourse.success')->with([
			'data'	=> $request->all(),
		]);
	}
	
}
