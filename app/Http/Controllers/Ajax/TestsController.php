<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Test;

class TestsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$tests = Test::with('questions', 'course')->get();
		return $tests;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$validation = $this->_validateTest($request->all());
		
		$data = $validation->data;
		$data['errors'] = $validation->errors;
		
		return $data;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$test = Test::with('course', 'questions', 'questions.answers')->findOrFail($id);

		foreach($test->questions as $question)
		{
			foreach($question->answers as $key => &$answer)
			{
				$answer->is_correct = $answer->is_correct ? true : false;

				if(!$question->correct_answer and $answer->is_correct)
				{
					$question->correct_answer = $key;
				}
			}
		}
		
		return $test;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$test = Test::with('course', 'questions')->findOrFail($id);

		foreach($test->questions as $question)
		{
			foreach($question->answers as $key => &$answer)
			{
				$answer->is_correct = $answer->is_correct ? true : false;

				if($question->type == 'CHOICE' and $answer->is_correct)
				{
					$question->correct_answer = $answer->id;
				}
			}
		}

		return $test;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$test = Test::with('course', 'questions')->find($id);
		if($test)
		{
			$validation = $this->_validateTest($request->all());
			
			$data = $validation->data;
			$data['errors'] = $validation->errors;
			
			return $data;
		}
		
		return [
			'error' 		=> true,
			'not_found'		=> true,
		];
	}
	
	protected function _validateTest($data)
	{
		// sleep(2);
		
		$errors = [
			'messages' => [ ],
			'questions' => [ ],
			'test' => [ ],
		];
		
		if(!@$data['title'] || strlen(trim($data['title'])) == 0)
		{
			$errors['messages'][] = "Kokeen otsikko puuttuu!";
			$errors['test'][] = "Kokeen otsikko puuttuu!";
		}
		
		if(!@$data['description'] || strlen(trim($data['description'])) == 0)
		{
			$errors['messages'][] = "Kokeen kuvaus puuttuu!";
			$errors['test'][] = "Kokeen kuvaus puuttuu!";
		}
		
		if(@$data['questions'] && count($data['questions']) > 0)
		{
			foreach($data['questions'] as $key => &$question)
			{
				if(strlen(trim($question['title'])) == 0)
				{
					$errors['messages'][] = "Kysymys " . ($key + 1) . ". puuttuu!";
					$errors['questions'][$key][] = "Itse kysymyksen teksti puuttuu!";
				}
				
				switch($question['type'])
				{
					case 'CHOICE':
					case 'MULTI':
					case 'MULTITEXT':
						$non_empty_answers = 0;
						
						foreach($question['answers'] as $akey => &$answer)
						{
							if(strlen(trim($answer['text'])) == 0)
							{
								if(count($question['answers']) > 2)
								{
									if($question['type'] == 'CHOICE' && $question['correct_answer'] == $akey)
									{
										$question['correct_answer'] = 0;
									}
									
									unset($question['answers'][$akey]);
								}
							}
							else
							{
								$non_empty_answers++;
							}
						}
						
						$question['answers'] = array_values($question['answers']);
						
						if($non_empty_answers < 2)
						{
							if($question['type'] != 'MULTITEXT')
							{
								$errors['messages'][] = "Kysymyksellä " . ($key + 1) . ". pitää olla ainakin 2 vaihtoehtoa.";
								$errors['questions'][$key][] = "Kysymyksellä pitää olla ainakin 2 vaihtoehtoa";
							}
							else
							{
								$errors['messages'][] = "Kysymyksellä " . ($key + 1) . ". pitää olla ainakin 2 vastausta.";
								$errors['questions'][$key][] = "Kysymyksellä pitää olla ainakin 2 vastausta.";
							}
						}
					break;
					case 'TEXT':
						if(strlen(trim($question['answers'][0]['text'])) == 0)
						{
							$errors['messages'][] = "Kysymyksen " . ($key + 1) . ". vastaus ei voi olla tyhjä.";
							$errors['questions'][$key][] = "Kysymyksen vastaus ei voi olla tyhjä.";
						}
					break;
					case 'TEXTAREA':
						
					break;
					default:
						$errors['messages'][] = "Hax! Kysymyksen tyyppiä " . $question['type'] . " ei ole olemassa!";
					break;
				}
			}
		}
		else
		{
			$errors['messages'][] = "Kokeessa ei ole yhtäkään kysymystä!";
			$errors['test'][] = "Kokeessa ei ole yhtäkään kysymystä!";
		}
		
		return (object)[
			'data' 		=> $data,
			'errors' 	=> $errors,
		];
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
