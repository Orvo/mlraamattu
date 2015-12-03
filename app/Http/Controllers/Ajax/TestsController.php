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
		$tests = Test::all();
		foreach($tests as $test)
		{
			$test->questions;
			$test->course;
		}
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
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$test = Test::findOrFail($id);

		$test->course;

		foreach($test->questions as $question)
		{
			foreach($question->answers as $key => &$answer)
			{
				$answer->is_correct = $answer->is_correct ? true : false;

				if(!$question->correct_answer and $answer->is_correct)
				{
					$question->correct_answer = $answer->id;
				}
			}
		}

		// dd($test->questions);
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
			$data = $request->all();
			unset($data['questions'][2]);
			return $data;
		}
		
		return [
			'error' 		=> true,
			'not_found'		=> true,
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
