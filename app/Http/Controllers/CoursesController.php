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
		$course = Course::with('tests', 'tests.questions')->has('tests.questions', '>', 0)->published()->findOrFail($id);

		return view('course.show', [
			'course' => $course,
		]);
	}
	
}
