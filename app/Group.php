<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Group extends Model
{
	
	public function teacher()
	{
		return $this->belongsTo('App\User', 'teacher_id');
	}
	
	public function users()
	{
		return $this->belongsToMany('App\User');
	}
	
	public function join($user = false)
	{
		if(!$user)
		{
			$user = Auth::user();
		}
		
		if($user->isInGroup($this->id))
		{
			return false;
		}
		
		$user->groups()->attach($this->id);
		
		return true;
	}
	
	public function leave($user = false)
	{
		if(!$user)
		{
			$user = Auth::user();
		}
		
		if(!$user->isInGroup($this->id))
		{
			return false;
		}
		
		$user->groups()->detach($this->id);
		
		return true;
	}
	
}
