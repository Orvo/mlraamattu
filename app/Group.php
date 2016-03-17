<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
	
}
