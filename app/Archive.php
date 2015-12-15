<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $table = 'archive';
    
	public function test()
	{
		return $this->belongsTo("App\Test");
	}
    
	public function user()
	{
		return $this->belongsTo("App\User");
	}

}