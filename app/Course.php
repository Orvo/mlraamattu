<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \Auth;
use App\Archive;
use App\Test;

class Course extends Model
{
	private $courseProgress = null;
	
    public function tests()
    {
    	return $this->hasMany('App\Test')->orderBy('order');
    }
    
    public function courseProgress()
    {
    	if(!Auth::check()) return (object)[
    		'completed' => false,
    		'num_completed' => 0,
    	];
    	
    	if($this->courseProgress !== null)
    	{
    		return $this->courseProgress;
    	}
    	
    	$archive = Auth::user()->archives;
    	
    	$num_completed = 0;
    	foreach($this->tests as $test)
    	{
    		if($test->isCompleted(true))
    		{
    			$num_completed++;
    		}
    	}
    	
    	$this->courseProgress = (object)[
    		'completed'		=> $num_completed == $this->tests->count(),
    		'num_completed' => $num_completed,
    		'total' 		=> $this->tests->count(),
    	];
    	
    	return $this->courseProgress;
    }
    
    public function isPublished()
    {
        return $this->published == 1;
    }
    
}
