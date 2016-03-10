<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \Auth;
use App\Archive;
use App\Test;

class Course extends Model
{
	private $courseProgress = null;
	
	const UNSTARTED		= 1;
	const STARTED 		= 2;
	const IN_PROGRESS	= 3;
	const COMPLETED 	= 4;
		
	public function tests()
	{
		return $this->hasMany('App\Test')->orderBy('order');
	}
	
	public function scopePublished()
	{
		return $this->where('published', 1);
	}
	
	public function getNextTestAttribute()
	{
		$result = false;
		
		if(!Auth::check())
		{
			$result = $this->tests()->first();
		}
		else
		{
			foreach($this->tests()->get() as $test)
			{
				if(!$test->hasQuestions()) continue;
				if($test->hasFeedback(true)) continue;
				
				if($test->progress->status == \App\Test::UNSTARTED || $test->progress->status == \App\Test::IN_PROGRESS)
				{
			 		$result = $test;
				}
			}
		}
		
		if($result)
		{
			$result->goToMaterial = $result->page()->exists() && $result->progress->status == \App\Test::UNSTARTED;
		}
		
		return $result;
	}
	
	public function getCourseProgressAttribute()
	{
		if(!Auth::check())
		{
			return (object)[
				'completed' 		=> false,
				'num_completed' 	=> 0,
				'status'			=> Course::UNSTARTED,
			];
		}
		
		if($this->courseProgress !== null)
		{
			return $this->courseProgress;
		}
		
		$courseStarted = false;
		
		$numTestsTotal = $this->tests()->has('questions')->count();
		
		$num_completed = 0;
		$num_partially_completed = 0;
		foreach($this->tests as $test)
		{
			if(!$courseStarted && $test->userHasArchive())
			{
				$courseStarted = true;
			}
			
			if($test->isCompleted(true))
			{
				$num_completed++;
				$num_partially_completed++;
			}
			elseif($test->isCompleted(false))
			{
				$num_partially_completed++;
			}
		}
		
		$status = Course::UNSTARTED;
		
		if($num_completed == $numTestsTotal)
		{
			$status = Course::COMPLETED;
		}
		elseif($num_completed > 0 || $num_partially_completed > 0)
		{
			$status = Course::IN_PROGRESS;
		}
		elseif($courseStarted)
		{
			$status = Course::STARTED;
		}
		
		$this->courseProgress = (object)[
			'status'					=> $status,
			
			'isCourseStarted'			=> $courseStarted,
			'isCompleted'				=> $num_completed == $numTestsTotal,
			
			'numCompleted' 				=> $num_completed,
			'numPartiallyCompleted' 	=> $num_partially_completed,
			'numTotal' 					=> $numTestsTotal,
		];
		
		return $this->courseProgress;
	}
	
	public function isPublished()
	{
		return $this->published == 1;
	}
	
}
