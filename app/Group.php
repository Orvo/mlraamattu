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
		
		$user->groups()->attach($this->id);
	}
	
	public function leave($user = false)
	{
		if(!$user)
		{
			$user = Auth::user();
		}
		
		$user->groups()->detach($this->id);
	}
	
}
