<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\TestValidator;

use \Auth;
use \Hash;

use App\User;
use App\Test;
use App\Group;
use App\Archive;

use Mail;

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
		
		$viewData = [
			'test' 					=> $test,
				
			'hasPassed' 			=> false,
			'hasPassedFull' 		=> false,
			'minimumToPass' 		=> ceil($test->questions()->count() * 0.5),
			
			'validation' 			=> false,
			'given_answers'			=> [],
			'feedback'				=> [],
			
			'authentication_type' 	=> 0,
			'isMaterialPage'		=> false,
		];
		
		$data = [];
		if(Auth::check())
		{
			$archive = Auth::user()->archives()->where('test_id', $id)->first();
			
			if($archive && $archive->data)
			{
				$data = (object)json_decode($archive->data, true);
				$viewData['given_answers'] 	= $data->given_answers;
				
				if(@$data->feedback)
				{
					$viewData['feedback'] 		= $data->feedback;
				}
				
				$fullValidation 			= $testvalidator->WithAnswers($test, $data->given_answers);
				$viewData['validation'] 	= $fullValidation['validation'];
				
				$viewData['hasPassed'] 		= ($fullValidation['num_correct'] / $fullValidation['total']) >= 0.5;
				$viewData['hasPassedFull'] 	= $fullValidation['num_correct'] == $fullValidation['total'];
			}
		}
		
		return view('test.show')->with($viewData);
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
	
	public function material_popup($id)
	{
		$test = Test::with('page')->has('page')->find($id);
		
		if($test && !$test->page->hidden)
		{
			return view('test.material-popup')->with([
				'test' 		=> $test,
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
		$hasPassed 		= ($validation['num_correct'] / $validation['total']) >= 0.5;
		$hasPassedFull		= $validation['num_correct'] == $validation['total'];
		$minimumToPass 	= ceil($validation['total'] * 0.5);
		
		$customErrors = new MessageBag;
		$errors = [];
		
		if(!Auth::check())
		{
			$authenticationType = $request->input('authentication_type');
			
			switch($authenticationType)
			{
				case 0:
					$authvalidator = \Validator::make($request->all(),
					[
						'user-name'		=> 'required',
						'user-email'	=> 'required|email|unique:users,email',
						'user-password'	=> 'required|min:8|confirmed',
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
					$authvalidator = \Validator::make($request->all(),
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
			
			$group = false;
			$shouldJoinGroup = false;
			
			if(strlen($request->input('group-code')) > 0)
			{
				$group = Group::where('code', $request->input('group-code'));
				
				if(!$group->exists())
				{
					$customErrors->add('group-code', 'Annettua ryhmää ei löytynyt. Syötä oikea ryhmäkoodi.');
				}
				else
				{
					$shouldJoinGroup = true;
				}
			}
			
			if($authvalidator->passes() && $customErrors->isEmpty())
			{
				switch($authenticationType)
				{
					case 0:
						$user = new User;
						$user->name = $request->input('user-name');
						$user->email = $request->input('user-email');
						$user->password = Hash::make($request->input('user-password'));
						$user->access_level = 'USER';
						$user->save();
						
						Mail::send('email.user_account_created',
						[
							'user' 		=> $user,
						],
						function($m) use ($user)
						{
							$m->to($user->email, $user->name)->subject('Käyttäjätunnus luotu Media7 raamattuopistoon');
						});
						
						Auth::login($user);
						
						if($shouldJoinGroup)
						{
							$group->first()->join();
						}
					break;
					case 1:
						$credentials = [
							'email' 	=> $request->input('user-login-email'),
							'password' 	=> $request->input('user-login-password'),
						];
						
						$remember = $request->input('remember_me');
						
						if(!Auth::attempt($credentials, $remember))
						{
							$customErrors->add('user-login-email', 'Kirjautuminen annetuilla tunnuksilla ei onnistunut!');
						}
						else
						{
							if($shouldJoinGroup)
							{
								$group->first()->join();
							}
							
							return redirect('/test/' . $test->id);
						}
					break;
				}
			}
		
			$errors = array_merge($authvalidator->errors()->all(), $customErrors->all());
		}
		
		if(Auth::check() && $customErrors->isEmpty())
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
				'hasPassed'				=> @$hasPassed,
				'hasPassedFull'			=> @$hasPassedFull,
				'minimumToPass'			=> @$minimumToPass,
				'authentication_type'	=> @$authenticationType,
				'isMaterialPage'		=> false,
				'authFailed'			=> !Auth::check() && !$authvalidator->passes(),
				
				'old'					=> $request->all(),
			]))
			->withInput($request)
			->withErrors(@$errors);
	}
	
	
}
