<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Test;
use App\Question;
use App\Answer;

class TestValidator 
{
	
	public function WithAnswers($test, $given_answers)
	{
		$all_correct = true;
		$num_correct = 0;
		$validation = [];
		
		foreach($test->questions as $question)
		{
			if(array_key_exists($question->id, $given_answers))
			{
				$result = $this->ValidateAnswer($question, $given_answers[$question->id]);
			}
			else
			{
				$result = [
					'correct' 	=> false,
					'status'	=> \App\Question::INCORRECT,
				];
			}
			
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
	
	public function WithRequest($test, Request $request)
	{
		$given_answers = [];
		foreach($test->questions as $question)
		{
			$answers = $request->input('answer-' . $question->id);
			$given_answers[$question->id] = $answers;
		}
		
		return $this->WithAnswers($test, $given_answers);
	}
	
	public function ValidateAnswer($question, $given_answer)
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
		
		$status = Question::INCORRECT;
		
		if($response['correct'])
		{
			$status = Question::CORRECT;
		}
		elseif(!$response['correct'] && @$response['partial'] > 0)
		{
			$status = Question::PARTIALLY_CORRECT;
		}
		
		$response['status'] = $status;
		
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