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
	
	public function getDataAttribute()
	{
		$value = json_decode($this->attributes['data']);
		
		if(is_null($value))
		{
			if($this->type == "MULTITEXT")
			{
				return (object)[
					'multitext_required' => $this->answers()->count(),
				];
			}
			
			return (object)[];
		}
		
		if(!property_exists($value, 'check'))
		{
			$value->check = 1;
		}
		
		return $value;
	}
	
	public function setDataAttribute($value)
	{
		if(is_object($value) && !property_exists($value, 'check'))
		{
			$value->check = 1;
		}
		
		if(is_array($value) && !array_key_exists('check', $value))
		{
			$value['check'] = 1;
		}
		
		$this->attributes['data'] = json_encode($value, JSON_FORCE_OBJECT);
	}
	
	public function correctAnswers()
	{
		switch($this->type)
		{
			case 'MULTI':
			case 'CHOICE':
				return $this->answers()->where('is_correct', 1)->get();
			break;
		}
		
		return $this->answers()->get();
	}
}
