<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	
	public function test()
	{
		return $this->belongsTo('App\Test');
	}
	
	public function getDescriptionAttribute()
	{
		return $this->getFirstParagraph($this->body);
	}
	
	protected function getFirstParagraph($string)
	{
		$start = stripos($string, '<p');
		$end = stripos($string, '</p>');
		
		return trim(strip_tags(substr($string, $start, $end-$start)));
	}
	
}
