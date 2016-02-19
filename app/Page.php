<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	
	protected $casts = [
		'hidden' => 'boolean'
	];
	
	public function test()
	{
		return $this->belongsTo('App\Test');
	}
	
	public function getDescriptionAttribute()
	{
		return $this->getFirstParagraph($this->body);
	}
	
	protected function getFirstParagraph($string, $offset = 0)
	{
		$start = stripos($string, '<p', $offset);
		$end = stripos($string, '</p>', $offset);
		
		if($start === false)
		{
			return '';
		}
		
		$result = trim(strip_tags(substr($string, $start, $end-$start)));
		
		if(strlen($result) > 0)
		{
			return $result;
		}
		else
		{
			return $this->getFirstParagraph($string, $end+4);
		}
	}
	
}
