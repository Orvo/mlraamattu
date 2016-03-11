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
	
	public function reviewer()
	{
		return $this->belongsTo("App\User", "reviewed_by");
	}
	
	public function getDiscardedAttribute($value)
	{
		if($this->attributes['replied_to']) return 0;

		return ($value || $this->test->autodiscard ? 1 : 0);
	}
	
	public function setDiscardedAttribute($value)
	{
		$this->attributes['discarded'] = $value;
	}

}
