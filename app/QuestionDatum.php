<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionDatum extends Model
{
	protected $hidden = ['created_at', 'updated_at'];
	
	public function question()
	{
		return $this->belongsTo('App\Question');
	}
	
	public function getHelloAttribute()
	{
		return 'HELLO';
	}
}
