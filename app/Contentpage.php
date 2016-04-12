<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contentpage extends Model
{
	
	protected $table = 'contentpages';
	
	public function scopePinned()
	{
		return $this->where('pinned', 1);
	}
	
	static public function tagExists($tag, $id = null)
	{
		
	}
	
}
