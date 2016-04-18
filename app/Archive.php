<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
	
	const NOT_DISCARDED			= 0;
	const VALITATED_DISCARDED	= 1;
	const FULLY_DISCARDED		= 2;
	
	protected $casts = [
		'test_id' 		=> 'integer',
		'course_id'		=> 'integer',
	];
	
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
		
		$result = 0;
		
		if($value)
		{
			$result = $value;
		}
		elseif($this->test && $this->test->autodiscard)
		{
			$result = $this->test->autodiscard;
		}
		
		return $result;
	}
	
	public function setDiscardedAttribute($value)
	{
		$this->attributes['discarded'] = $value;
	}

}
