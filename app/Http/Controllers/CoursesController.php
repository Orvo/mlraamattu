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
		$courses = Course::with('tests')->published()->get();
		
		$my_courses = [];
		$available_courses = [];
		
		foreach($courses as $key => $course)
		{
			if($course->tests->count() > 0)
			{
				$progress = $course->courseProgress;
				$course->progressStatus = $progress->status;
				
				if($progress->status == Course::UNSTARTED)
				{
					$available_courses[] = $course;
				}
				else
				{
					$my_courses[] = $course;
				}
			}
		}
		
		return view('course.list', [
			'my_courses' 		=> $my_courses,
			'available_courses' => $available_courses,
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
