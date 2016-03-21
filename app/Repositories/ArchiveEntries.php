<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Http\Requests;

use Auth;
use App\Archive;

class ArchiveEntries 
{
	
	public function getEntries()
	{
		if(Auth::user()->isTeacher())
		{
			$users = [];
			
			$archive = Archive::with('user', 'test', 'test.course', 'test.questions')
				->has('test')->has('user');
			
			foreach(Auth::user()->groups as $group)
			{
				foreach($group->users as $user)
				{
					$users[$user->id] = true;
				}
			}
			
			$archive->where(function($query) use ($users)
			{
				foreach(array_keys($users) as $key => $user_id)
				{
					if($key == 0)
					{
						$query->where('user_id', $user_id);
					}
					else
					{
						$query->orWhere('user_id', $user_id);
					}
				}
			});
			
			$archive = $archive->orderBy('created_at', 'ASC')->get();
		}
		else
		{
			$archive = Archive::with('user', 'test', 'test.course', 'test.questions')
				->has('test')->has('user')
				->orderBy('created_at', 'ASC')->get();
		}
		
		return $archive;
	}
	
}