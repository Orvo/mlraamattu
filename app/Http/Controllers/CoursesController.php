<?php

namespace App\Http\Controllers;

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
		return view('course.list', [
			'courses' => Course::all(),
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$user_completed = [];
		if(\Auth::check())
		{
			foreach(\Auth::user()->archives as $item)
			{
				$user_completed[$item->test_id] = json_decode($item->data);
			}
		}
		
		$course = Course::with('tests')->findOrFail($id);

		return view('course.tests', [
			'course' => $course,
			'user_completed' => $user_completed,
		]);
	}
	
}
