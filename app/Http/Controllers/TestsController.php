<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Test;

class TestsController extends Controller
{
	
	public function show($id)
	{
		$test = Test::findOrFail($id);
		
		return view('test.show')
				->with([
					'test' => $test,
				]);
	}
	
	public function check($id, Request $request)
	{
		$test = Test::findOrFail($id);
		
		$result = [];
		
		$derp = [];
		
		$validation = $this->_validateTestWithRequest($test, $request);
		
		// foreach($test->questions as $question)
		// {
		// 	$answers = $request->input('answer-' . $question->id);
		// 	$correct_answers = $question->answers->where('is_correct', 1);
			
		// 	$derp[] = [
		// 		"wasCorrect" => $this->_validateAnswer($question, $answers),
		// 		"answers" => $answers,
		// 		"correct" => $correct_answers,
		// 	];
		// }
		
		return response(json_encode($validation, JSON_PRETTY_PRINT))->header("Content-Type", "text/plain");
	}
	
	protected function _validateTestWithRequest($test, Request $request)
	{
		$validation = [];
		$all_correct = true;
		
		foreach($test->questions as $question)
		{
			$answers = $request->input('answer-' . $question->id);
			
			$result = $this->_validateAnswer($question, $answers);
			
			$all_correct = $all_correct && $result['correct'];
			
			$validation[$question->id] = $result;
		}
		
		return [
			'all_correct' => $all_correct,
			'validation' => $validation,
		];
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
		
		if($given_answer === null || (!is_array($given_answer) && strlen(trim($given_answer)) == 0))
		{
			return [
				'correct' 	=> false,
				'error' 	=> 'No given answer',
			];
		}
		
		$correct_answers = $question->answers->where('is_correct', 1);
		
		switch($question->type)
		{
			case 'CHOICE':
				return [
					'correct' 			=> $correct_answers->first()->id == $given_answer,
					'correct_answers' 	=> $correct_answers->first()->id,
				];
			break;
			
			case 'MULTI':
				$matched = [];
				foreach($correct_answers as $correct_answer)
				{
					if(in_array($correct_answer->id, $given_answer))
					{
						$matched[] = $correct_answer->id;
					}
				}
				
				return [
					'correct' 			=> count($matched) == $correct_answers->count() && $correct_answers->count() == count($given_answer),
					'partial' 			=> count($matched),
					'total'				=> $correct_answers->count(),
					'correct_answers' 	=> $correct_answers,
				];
			break;
			
			case 'TEXT':
				$correct_answer = $correct_answers->first();
				
				return [
					'correct' 			=> $this->_string_match($correct_answer->text, $given_answer, 10),
					'correct_answers'	=> $correct_answer->text,
				];
			break;
			
			case 'MULTITEXT':
				$matched = [];
				if(count($given_answer) > 0)
				{
					foreach($correct_answers as $correct_answer)
					{
						foreach($given_answer as $key => $answer)
						{
							if($this->_string_match($correct_answer->text, $answer, 10))
							{
								$matched[] = $answer;
								unset($given_answer[$key]);
								break;
							}
						}
					}
				}
				
				return [
					'correct'			=> count($matched) == $correct_answers->count(),
					'partial'			=> count($matched),
					'total'				=> $correct_answers->count(),
				];
			break;
			
			case 'TEXTAREA':
				// Text area just needs to be something else than empty
				return [
					'correct' => strlen($given_answer) > 0,
				];
			break;
		}
		
		return [
			'correct' 	=> false,
			'error'		=> 'Invalid question type.',
		];
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
