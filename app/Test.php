<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \Auth;
use App\Archive;

class Test extends Model
{
	private $unlockStatus = null;
	private $hasFeedbackStatus = null;
	
	const LOCKED			= 1;
	const UNSTARTED			= 2;
	const IN_PROGRESS		= 3;
	const COMPLETED 		= 4;
	
	const NO_FEEDBACK		= 1;
	const HAS_FEEDBACK		= 2;
	const IS_DISCARDED		= 3;
	
	const NO_AUTODISCARD	= 0;
	const REQUIRE_CORRECT	= 1;
	const FULL_AUTODISCARD	= 2;
	
	protected $casts = [
		'id' 		=> 'integer',
	];
	
	public function course()
	{
		return $this->belongsTo('App\Course');
	}

	public function questions()
	{
		return $this->hasMany('App\Question')->orderBy('order');
	}
	
	public function page()
	{
		return $this->hasOne('App\Page');
	}
	
	private $_feedbackStatus = null;
	
	public function getFeedbackStatusAttribute()
	{
		if(!Auth::check())
		{
			return Test::NO_FEEDBACK;
		}
		
		if(!is_null($this->_feedbackStatus))
		{
			return $this->_feedbackStatus;
		}
		
		$status = Test::NO_FEEDBACK;
		
		$archive = Auth::user()->archives()->where([
			'test_id' => $this->id,
		])->first();
		
		if($archive)
		{
			if($archive->replied_to)
			{
				$status = Test::HAS_FEEDBACK;
			}
			elseif($archive->discarded)
			{
				$status = Test::IS_DISCARDED;
			}
		}
		
		$this->_feedbackStatus = $status;
		
		return $this->_feedbackStatus;
	}
	
	public function hasFeedback()
	{
		return $this->feedbackStatus == Test::HAS_FEEDBACK;
	}
	
	public function hasQuestions()
	{
		return $this->questions()->exists();
	}
	
	public function isPublished()
	{
		return $this->course->isPublished();
	}
	
	public function isCompleted($requireFullCompletion = false, $user = false)
	{
		if(Auth::check() || $user !== false)
		{
			$archive = Archive::where([
				'test_id' => $this->id,
				'user_id' => ($user === false ? Auth::user()->id : $user->id)
			])->first();
			
			if($archive)
			{
				$data = json_decode($archive->data, true);
				
				return $data['all_correct'] ||
					   $archive->replied_to ||
					   $archive->discarded == \App\Archive::FULLY_DISCARDED ||
					   (!$requireFullCompletion && ($data['num_correct'] >= $data['total'] * 0.5));
			}
		}
		
		return false;
	}
	
	public function userHasArchive()
	{
		if(!Auth::check())
		{
			return false;
		}
		
		return Auth::user()->archives()->where('test_id', $this->id)->exists();
	}
	
	public function isUnlocked()
	{
		if($this->unlockStatus !== null)
		{
			return $this->unlockStatus;
		}
		
		$this->unlockStatus = false;
		
		if(!Auth::check())
		{
			// Unlogged users are only allowed to complete first test of each course
			$this->unlockStatus = $this->course->tests->first()->id == $this->id;
		}
		else
		{
			if(Auth::user()->archives()->where('test_id', $this->id)->exists() || Auth::user()->isAdmin())
			{
				$this->unlockStatus = true;
			}
			else
			{
				$previous_key = 0;
				foreach($this->course->tests as $key => $test)
				{
					if($test->id == $this->id)
					{
						$this->unlockStatus = ($key == 0 || $this->course->tests[$previous_key]->isCompleted());
						break;
					}
					
					$previous_key = $key;
				}
			}
		}
		
		return $this->unlockStatus;
	}
	
	protected $progress = null;
	public function getProgressAttribute()
	{
		if(!Auth::check())
		{
			return (object)[
				'status' 	=> $this->isUnlocked() ? Test::UNSTARTED : Test::LOCKED,
				'data'		=> false,
			];
		}
		
		if(!is_null($this->progress))
		{
			return $this->progress;
		}
		
		$data = false;
		
		$status = $this->isUnlocked() ? Test::UNSTARTED : Test::LOCKED;
		
		if($status != Test::LOCKED && $this->userHasArchive())
		{
			$archive = Auth::user()->archives()->where('test_id', $this->id)->first();
			$data = json_decode($archive->data);
			
			if($data->all_correct)
			{
				$status = Test::COMPLETED;
			}
			else
			{
				$status = Test::IN_PROGRESS;
			}
		}
		
		$this->progress = (object)[
			'status' 	=> $status,
			'data'		=> $data,
		];
		
		return $this->progress;
	}
}
