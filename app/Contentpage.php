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
	
	static public function isUniqueTag($tag, $id = false)
	{
		$page = Contentpage::where('tag', $tag);
		
		if($id)
		{
			$page = $page->where('id', '!=', $id);
		}
		
		return !$page->exists();
	}
	
	public function getViewData()
	{
		return [
			'page' 				=> $this,
			'sidebar_before'	=> $this->sticky_sidebar == 1,
		];
	}
	
}
