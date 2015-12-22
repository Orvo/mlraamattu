<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Course;
use App\Test;

use \DB;

class CoursesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$courses = Course::with('tests')->where('published', 1)->get();
		
		foreach($courses as $key => $course)
		{
			if($course->tests->count() == 0)
			{
				unset($courses[$key]);
			}
		}
		
		return view('course.list', [
			'courses' => $courses,
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
		
		$course = Course::with('tests')->where([
			'id' => $id,
			'published' => 1,
		])->firstOrFail();

		return view('course.tests', [
			'course' => $course,
			'user_completed' => $user_completed,
		]);
	}
	
}
