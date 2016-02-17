<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Test;
use App\Page;
use App\Question;
use App\Answer;

class TestsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$tests = Test::with('questions', 'page', 'course')->get();
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
		
		if($validation->passed)
		{
			$data['test_created'] = $this->_saveTest($data);
		}
		
		return $data;
	}
	
	protected function _saveTest($data)
	{
		$isNewEntry = !array_key_exists('id', $data);
		
		if($isNewEntry)
		{
			$test = new Test();
			
			$latest_test_on_course = Test::where([
				'course_id' => $data['course']['id']
			])->orderBy('order', 'DESC')->first();
			
			$next_course_order 	= ($latest_test_on_course ? $latest_test_on_course->order : 0) + 1;
			$test->order 		= $next_course_order;
		}
		else
		{
			$test = Test::find($data['id']);
			
			$submitted_questions = [];
			foreach($data['questions'] as $qkey => $qdata)
			{
				if(array_key_exists('id', $qdata))
				{
					$submitted_questions[] = $qdata['id'];
				}
			}
			
			foreach($test->questions as $question)
			{
				if(!in_array($question->id, $submitted_questions))
				{
					$question->delete();
				}
			}
			
			if($test->course->id != $data['course']['id'])
			{
				$latest_test_on_course = Test::where([
					'course_id' => $data['course']['id']
				])->orderBy('order', 'DESC')->first();
				
				$next_course_order 	= ($latest_test_on_course ? $latest_test_on_course->order : 0) + 1;
				$test->order 		= $next_course_order;
			}
		}
		
		$test->course_id 	= $data['course']['id'];
		
		$test->title 		= $data['title'];
		$test->description 	= $data['description'];
		
		$test->save();
		
		///////////////////////
		
		$isNewPage = !array_key_exists('id', $data['page']);
		
		$pageBody = trim($data['page']['body']);
		$savePage = strlen($pageBody) > 0;
		
		if($isNewPage)
		{
			$page = new Page();
		}
		else
		{
			$page = $test->page;
		}
		
		$page->test_id = $test->id;
		$page->body = trim($data['page']['body']);
		
		if($savePage)
		{
			$page->save();
		}
		elseif(!$isNewPage)
		{
			$page->delete();
		}
		
		/////////////////////////
		
		foreach($data['questions'] as $qkey => $question_data)
		{
			if(!array_key_exists('id', $question_data))
			{
				$question = new Question();
			}
			else
			{
				$question = Question::find($question_data['id']);
				
				$submitted_answers = [];
				foreach($question_data['answers'] as $adata)
				{
					if(array_key_exists('id', $adata))
					{
						$submitted_answers[] = $adata['id'];
					}
				}
				
				foreach($question->answers as $akey => $answer)
				{
					if(!in_array($answer->id, $submitted_answers) ||
					   ($question_data['type'] == "TEXT" && $akey > 0) || $question_data['type'] == "TEXTAREA")
					{
						$answer->delete();
					}
				}
			}
			
			$question->test_id 	= $test->id;
			
			$question->type 	= $question_data['type'];
			$question->title 	= $question_data['title'];
			$question->subtitle = $question_data['subtitle'];
			
			$question->order 	= $qkey + 1;
			
			$question->save();
			
			foreach($question_data['answers'] as $akey => $answer_data)
			{
				if(!array_key_exists('id', $answer_data))
				{
					$answer = new Answer();
				}
				else
				{
					$answer = Answer::find($answer_data['id']);
				}
				
				$answer->question_id 	= $question->id;
				
				$answer->text 			= $answer_data['text'];
				$answer->is_correct 	= @$answer_data['is_correct'] ? true : false;
				$answer->error_margin 	= 10;
				
				$answer->save();
			}
		}
		
		return $test->id;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$test = Test::with('course', 'page', 'questions', 'questions.answers')->findOrFail($id);

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
		$test = Test::with('course', 'page', 'questions')->findOrFail($id);

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
		$test = Test::find($id);
		
		if($test)
		{
			$validation = $this->_validateTest($request->all());
			
			$data = $validation->data;
			$data['errors'] = $validation->errors;
			
			if($validation->passed)
			{
				$data['test_edited'] = $this->_saveTest($data);
			}
			
			return $data;
		}
		
		return [
			'error' 		=> true,
			'not_found'		=> true,
		];
	}
	
	protected function _validateTest($data)
	{
		$errors = [
			'messages' => [],
			'questions' => [],
			'test' => [],
			'fields' => [],
		];
		
		if(!@$data['title'] || strlen(trim($data['title'])) == 0)
		{
			$errors['messages'][] = "Kokeen otsikko puuttuu!";
			$errors['test'][] = "Kokeen otsikko puuttuu!";
			$errors['fields']['test_title'] = true;
		}
		
		if(!@$data['description'] || strlen(trim($data['description'])) == 0)
		{
			$errors['messages'][] = "Kokeen kuvaus puuttuu!";
			$errors['test'][] = "Kokeen kuvaus puuttuu!";
			$errors['fields']['test_description'] = true;
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
								$errors['messages'][] = "Kysymyksellä " . ($key + 1) . ". pitää olla ainakin 2 vaihtoehtoa. Tyhjää riviä ei lasketa.";
								$errors['questions'][$key][] = "Kysymyksellä pitää olla ainakin 2 vaihtoehtoa. Tyhjää riviä ei lasketa.";
							}
							else
							{
								$errors['messages'][] = "Kysymyksellä " . ($key + 1) . ". pitää olla ainakin 2 vastausta. Tyhjää riviä ei lasketa.";
								$errors['questions'][$key][] = "Kysymyksellä pitää olla ainakin 2 vastausta. Tyhjää riviä ei lasketa.";
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
			$errors['fields']['add_questions'] = true;
		}
		
		return (object)[
			'data' 		=> $data,
			'errors' 	=> $errors,
			'passed'	=> count($errors['messages']) == 0,
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
		$test = Test::with('questions', 'questions.answers')->findOrFail($id);
		
		foreach($test->questions as $question)
		{
			foreach($question->answers as $answer)
			{
				$answer->delete();
			}
			
			$question->delete();
		}
		
		$test->delete();
	}
}
