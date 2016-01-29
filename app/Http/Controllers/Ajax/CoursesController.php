<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Course;
use App\Test;

class CoursesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return Course::with('tests')->get();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$validation = $this->_validate($request->all());
		
		$data = $validation->data;
		$data['errors'] = $validation->errors;
		
		if($validation->passed)
		{
			$data['course_created'] = $this->_save($data);
		}
		
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
		$course = Course::with('tests', 'tests.questions')->findOrFail($id);
		return $course;
		
		// return [
		// 	'error' => true,
		// 	'status' => 404,
		// ];
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
		$validation = $this->_validate($request->all());
		
		$data = $validation->data;
		$data['errors'] = $validation->errors;
		
		if($validation->passed)
		{
			$data['course_edited'] = $this->_save($data);
		}
		
		return $data;
	}
	
	protected function _validate($data)
	{
		$errors = [
			'messages' => [],
			'fields' => [],
		];
		
		$isNewEntry = !array_key_exists('id', $data);
		
		if(!@$data['title'] || strlen(trim($data['title'])) == 0)
		{
			$errors['messages'][] = "Kurssin otsikko puuttuu!";
			$errors['fields']['course_title'] = true;
		}
		else if($isNewEntry)
		{
			if(Course::where(['title' => $data['title']])->exists())
			{
				$errors['messages'][] = "Kurssi samalla otsikolla on jo olemassa.";
				$errors['fields']['course_title'] = true;
			}
		}
		
		
		if(!@$data['description'] || strlen(trim($data['description'])) == 0)
		{
			$errors['messages'][] = "Kurssin kuvaus puuttuu!";
			$errors['fields']['course_description'] = true;
		}
		
		return (object)[
			'data' 		=> $data,
			'errors' 	=> $errors,
			'passed'	=> count($errors['messages']) == 0,
		];
	}
	
	protected function _save($data)
	{
		$isNewEntry = !array_key_exists('id', $data);
		
		if($isNewEntry)
		{
			$course = new Course();
		}
		else
		{
			$course = Course::find($data['id']);
		}
		
		$course->title = $data['title'];
		$course->description = $data['description'];
		
		$course->published = $data['published'];
		
		$course->save();
		
		if(!$isNewEntry)
		{
			foreach($data['tests'] as $key => $tdata)
			{
				$test = Test::find($tdata['id']);
				$test->order = $key + 1;
				
				$test->save();
			}
		}
		
		return $course->id;
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
