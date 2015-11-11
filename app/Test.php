<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
	public function course()
    {
    	return $this->belongsTo('App\Course');
    }

    public function questions()
    {
    	return $this->hasMany('App\Question');
    }
}
