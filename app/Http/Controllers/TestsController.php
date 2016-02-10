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
				$minimumToPass 	= ceil($validation['total'] * 0.5);
			}
		}
		
		return view('test.show')
			->with([
				'test' 			=> $test,
				'given_answers' => @$data->given_answers,
				'feedback' 		=> @$data->feedback,
				'hasPassed'		=> @$passed,
				'validation' 	=> @$validation['validation'],
				'minimumToPass'	=> @$minimumToPass,
			]);
	}
	
	public function check($id, Request $request, TestValidator $testvalidator)
	{
		$test = Test::findOrFail($id);
		
		$validation = $testvalidator->WithRequest($test, $request);
		$passed 		= ($validation['num_correct'] / $validation['total']) >= 0.5;
		$minimumToPass 	= ceil($validation['total'] * 0.5);
		
		if(!Auth::check())
		{
			$v = \Validator::make($request->all(), [
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
			
			if($v->passes())
			{
				$user = new User;
				$user->name = $request->input('user-name');
				$user->email = $request->input('user-email');
				$user->password = Hash::make($request->input('user-password'));
				$user->save();
				
				Auth::login($user);
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
		
		// return response(json_encode($validation, JSON_PRETTY_PRINT))->header("Content-Type", "text/plain");

		return view('test.show')
			->with(array_merge($validation, [
				'test' 		=> $test,
				'feedback' 	=> @$data['feedback'],
				'hasPassed'		=> @$passed,
				'minimumToPass'	=> @$minimumToPass,
			]))
			->withErrors(@$v);
	}
	
	
}
