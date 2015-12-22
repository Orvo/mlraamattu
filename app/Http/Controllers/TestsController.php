<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use \Auth;
use \Hash;

use App\User;
use App\Test;
use App\Archive;

class TestsController extends Controller
{
	
	public function show($id)
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
				$validation = $this->_validateTestWithAnswers($test, $data->given_answers);
			}
		}
		
		return view('test.show')
			->with([
				'test' => $test,
				'given_answers' => @$data->given_answers,
				'validation' => @$validation['validation'],
			]);
	}
	
	public function check($id, Request $request)
	{
		// dd($request->all());
		
		$test = Test::findOrFail($id);
		
		$validation = $this->_validateTestWithRequest($test, $request);
		
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
			
			if(!$archive)
			{
				$archive = new Archive;
				$archive->user_id = Auth::user()->id;
				$archive->test_id = $test->id;
			}
			
			$data = $validation;
			unset($data['validation']);
			
			$archive->data = json_encode($data);
			$archive->save();
		}
		
		// return response(json_encode($validation, JSON_PRETTY_PRINT))->header("Content-Type", "text/plain");

		return view('test.show')
			->with(array_merge($validation, [
				'test' => $test
			]))
			->withErrors(@$v);
	}
	
	protected function _validateTestWithAnswers($test, $given_answers)
	{
		$all_correct = true;
		$num_correct = 0;
		$validation = [];
		
		foreach($test->questions as $question)
		{
			$result = $this->_validateAnswer($question, $given_answers[$question->id]);
			$validation[$question->id] = $result;
			
			$all_correct = $all_correct && $result['correct'];
			if($result['correct'])
			{
				$num_correct++;
			}
		}
		
		return [
			'all_correct'	=> $all_correct,
			'num_correct'	=> $num_correct,
			'total'			=> $test->questions->count(),
			
			'given_answers'	=> $given_answers,
			'validation'	=> $validation,
		];
	}
	
	protected function _validateTestWithRequest($test, Request $request)
	{
		$given_answers = [];
		foreach($test->questions as $question)
		{
			$answers = $request->input('answer-' . $question->id);
			$given_answers[$question->id] = $answers;
		}
		
		return $this->_validateTestWithAnswers($test, $given_answers);
	}
	
	protected function _validateAnswer($question, $given_answer)
	{
		if(!$question)
		{
			return [
				'correct' 	=> false,
				'error' 	=> 'Invalid question argument',
			];
		}
		
		$response = [];
		$empty_answer = ($given_answer === null || (!is_array($given_answer) && strlen(trim($given_answer)) == 0) || is_array($given_answer) && count($given_answer) == 0);
		
		$correct_answers = $question->answers->where('is_correct', 1);
		
		switch($question->type)
		{
			case 'CHOICE':
				$response = [
					'correct' 			=> $correct_answers->first()->id == $given_answer,
					'correct_answers' 	=> $correct_answers->first(),
				];
			break;
			
			case 'MULTI':
				$matched = [];
				
				if(!$empty_answer)
				{
					foreach($correct_answers as $correct_answer)
					{
						if(in_array($correct_answer->id, $given_answer))
						{
							$matched[] = $correct_answer->id;
						}
					}
				}
				
				$response = [
					'correct' 			=> count($matched) == $correct_answers->count() && $correct_answers->count() == count($given_answer),
					'partial' 			=> count($matched),
					'total'				=> $correct_answers->count(),
					'correct_answers' 	=> $correct_answers,
				];
			break;
			
			case 'TEXT':
				$correct_answer = $correct_answers->first();
				
				$response = [
					'correct' 			=> $this->_string_match($correct_answer->text, $given_answer, 10),
					'correct_answers'	=> $correct_answer,
				];
			break;
			
			case 'MULTITEXT':
				$matched = [];
				$correct_rows = [];
				
				if(!$empty_answer)
				{
					foreach($correct_answers as $correct_answer)
					{
						foreach($given_answer as $key => $answer)
						{
							if($this->_string_match($correct_answer->text, $answer, 10))
							{
								$matched[] = $answer;
								$correct_rows[$key] = true;
								unset($given_answer[$key]);
								break;
							}
						}
					}
				}
				
				$response = [
					'correct'			=> count($matched) == $correct_answers->count(),
					'partial'			=> count($matched),
					'total'				=> $correct_answers->count(),
					'correct_answers'	=> $correct_answers,
					'correct_rows'		=> $correct_rows,
				];
			break;
			
			case 'TEXTAREA':
				// Text area just needs to be something else than empty
				$response = [
					'correct' => strlen($given_answer) > 0,
				];
			break;
			
			default:
				$response = [
					'correct' 	=> false,
					'error'		=> 'Invalid question type.',
				];
			break;
		}
		
		if($empty_answer)
		{
			$response['correct'] = false;
			$response['empty_answer'] = true;
		}
		
		return $response;
	}
	
	protected function _string_match($str1, $str2, $margin)
	{
		$str1 = mb_strtoupper($this->_strip_punctuation($str1));
		$str2 = mb_strtoupper($this->_strip_punctuation($str2));

		if($margin > 0)
		{
			$margin = ceil(strlen($str1) * ($margin / 100.0));
			return levenshtein($str1, $str2) <= $margin;
		}
		
		return $str1 == $str2;
	}
	
	protected function _strip_punctuation($str)
	{
		return trim(str_replace(str_split('!\'\\"#€%&/()=?+-.,;:_@$£∞§|[]<>'), '', $str));
	}
	
}
