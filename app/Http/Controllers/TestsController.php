<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\TestValidator;

use \Auth;
use \Hash;

use App\User;
use App\Test;
use App\Archive;


class TestsController extends Controller
{
	
	public function show($id, TestValidator $testvalidator)
	{
		$test = Test::with('course')->findOrFail($id);
		if(!$test->isPublished()) abort(404);
		
		if(!$test->isUnlocked())
		{
			return redirect('course/' . $test->course->id)->with([
				'error' => 'Et voi vielä suorittaa koetta <b>' . $test->title . '</b>!'	
			]);
		}
		
		$data = [];
		if(Auth::check())
		{
			$archive = Auth::user()->archives()->where('test_id', $id)->first();
			
			if($archive && $archive->data)
			{
				$data = (object)json_decode($archive->data, true);
				$validation = $testvalidator->WithAnswers($test, $data->given_answers);
				
				$passed = ($validation['num_correct'] / $validation['total']) >= 0.5;
				$passedFull = $validation['num_correct'] == $validation['total'];
				$minimumToPass 	= ceil($validation['total'] * 0.5);
			}
		}
		
		return view('test.show')
			->with([
				'test' 					=> $test,
				'given_answers' 		=> @$data->given_answers,
				'feedback' 				=> @$data->feedback,
				'hasPassed'				=> @$passed,
				'hasPassedFull'			=> @$passedFull,
				'validation' 			=> @$validation['validation'],
				'minimumToPass'			=> @$minimumToPass,
				'authentication_type' 	=> 0,
			]);
	}
	
	public function material($id)
	{
		$test = Test::with('page')->has('page')->find($id);
		
		if($test && !$test->page->hidden)
		{
			return view('test.material')->with([
				'test' 				=> $test,
				'isMaterialPage' 	=> true,
			]);
		}
		else
		{
			return redirect('/test/' . $id);
		}
	}
	
	public function check($id, Request $request, TestValidator $testvalidator)
	{
		$test = Test::findOrFail($id);
		
		$validation 	= $testvalidator->WithRequest($test, $request);
		$passed 		= ($validation['num_correct'] / $validation['total']) >= 0.5;
		$passedFull		= $validation['num_correct'] == $validation['total'];
		$minimumToPass 	= ceil($validation['total'] * 0.5);
		
		$submit_login = false;
		
		if(!Auth::check())
		{
			$authenticationType = $request->input('authentication_type');
			
			switch($authenticationType)
			{
				case 0:
					$validator = \Validator::make($request->all(),
					[
						'user-name'		=> 'required',
						'user-email'	=> 'required|email|unique:users,email',
						'user-password'	=> 'required|min:8|confirmed'
					],
					[
						'user-name.required'		=> 'Nimi on pakollinen.',
						'user-email.required'		=> 'Sähköpostiosoite on pakollinen.',
						'user-email.email'			=> 'Annettu sähköpostiosoite ei ole pätevä.',
						'user-email.unique'			=> 'Tunnus samalla sähköpostiosoitteella on jo olemassa.',
						'user-password.required'	=> 'Salasana on pakollinen.',
						'user-password.min'			=> 'Salasanan pitää olla ainakin :min merkkiä pitkä.',
						'user-password.confirmed'	=> 'Salasanat eivät täsmää.',
					]);
				break;
				case 1:
					$validator = \Validator::make($request->all(),
					[
						'user-login-email'		=> 'required|email',
						'user-login-password'	=> 'required'
					],
					[
						'user-login-email.required'		=> 'Sähköpostiosoite on pakollinen.',
						'user-login-email.email'		=> 'Annettu sähköpostiosoite ei ole pätevä.',
						'user-login-password.required'	=> 'Salasana on pakollinen.',
					]);
				break;
			}
			
			if($validator->passes())
			{
				switch($authenticationType)
				{
					case 0:
						$user = new User;
						$user->name = $request->input('user-name');
						$user->email = $request->input('user-email');
						$user->password = Hash::make($request->input('user-password'));
						$user->save();
						
						Auth::login($user);
					break;
					case 1:
						$credentials = [
							'email' 	=> $request->input('user-login-email'),
							'password' 	=> $request->input('user-login-password'),
						];
						
						$remember = $request->input('remember_me');
						
						if(!Auth::attempt($credentials, $remember))
						{
							$validator->getMessageBag()->add('user-login-email', 'Kirjautuminen annetuilla tunnuksilla ei onnistunut!');
						}
						else
						{
							return redirect('/test/' . $test->id);
						}
					break;
				}
			}
		}
		
		if(Auth::check())
		{
			$archive = Auth::user()->archives()->where('test_id', $id)->first();
			
			$data = $validation;
			
			if(!$archive)
			{
				$archive = new Archive;
				$archive->user_id = Auth::user()->id;
				$archive->test_id = $test->id;
			}
			else
			{
				$old_data = json_decode($archive->data, true);
				
				if(@$old_data['feedback'])
				{
					$data['feedback'] = $old_data['feedback'];
				}
			}
			
			$archive->data = json_encode($data);
			$archive->save();
		}
		
		return view('test.show')
			->with(array_merge($validation, [
				'test' 					=> $test,
				'feedback' 				=> @$data['feedback'],
				'hasPassed'				=> @$passed,
				'hasPassedFull'			=> @$passedFull,
				'minimumToPass'			=> @$minimumToPass,
				'authentication_type'	=> @$authenticationType,
			]))
			->withErrors(@$validator)
			->withInput($request);
	}
	
	
}
