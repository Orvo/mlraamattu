<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	public $timestamps = false;
	
	const INCORRECT             = 1;
	const PARTIALLY_CORRECT     = 2;
	const CORRECT               = 3;
	
	public function test()
	{
		return $this->belongsTo('App\Test');
	}

	public function answers()
	{
		return $this->hasMany('App\Answer');
	}
	
	public function correctAnswers()
	{
		return $his->answers()->where('is_correct', 1)->get();
	}
}
