<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\Group;

class GroupsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if(Auth::user()->isAdmin())
		{
			return Group::with('teacher', 'users')->get();
		}
		elseif(Auth::user()->isTeacher())
		{
			return Group::with('teacher', 'users')->where('teacher_id', Auth::user()->id)->get();	
		}
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$validation = $this->_validate($request->all());
		
		$data = $validation->data;
		$data['errors'] = $validation->errors;
		
		if($validation->passed)
		{
			$data['group_created'] = $this->_save($data);
		}
		
		return $data;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return Group::with('teacher', 'users')->findOrFail($id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$validation = $this->_validate($request->all());
		
		$data = $validation->data;
		$data['errors'] = $validation->errors;
		
		if($validation->passed)
		{
			$data['group_edited'] = $this->_save($data);
		}
		
		return $data;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$group = Group::findOrFail($id);
		
		if($group)
		{
			$group->delete();
			
			return [
				'success' => true,
			];
		}
		
		return [
			'success' => true,
		];
	}
	
	protected function _validate($data)
	{
		$errors = [
			'messages' => [],
			'fields' => [],
		];
		
		$isNewEntry = !array_key_exists('id', $data);
		
		$codeHasChanged = false;
		
		if(!$isNewEntry)
		{
			$group = Group::find($data['id']);
			$codeHasChanged = (trim($data['code']) != $group->code);
		}
		
		if(!@$data['title'] || strlen(trim($data['title'])) == 0)
		{
			$errors['messages'][] = "Ryhmän nimi puuttuu!";
			$errors['fields']['group_title'] = true;
		}
		
		if(!@$data['code'] || strlen(trim($data['code'])) == 0)
		{
			$errors['messages'][] = "Ryhmän liittymiskoodi puuttuu!";
			$errors['fields']['group_code'] = true;
		}
		elseif($isNewEntry || $codeHasChanged)
		{
			if(Group::where('code', trim($data['code']))->exists())
			{
				$errors['messages'][] = "Ryhmä samalla liittymiskoodilla on jo olemassa!";
				$errors['fields']['group_code'] = true;
			}
		}
		
		return (object)[
			'data' 		=> $data,
			'errors' 	=> $errors,
			'passed'	=> count($errors['messages']) == 0,
		];
	}
	
	protected function _save($data)
	{
		$isNewEntry = !array_key_exists('id', $data);
		
		if($isNewEntry)
		{
			$group = new Group();
		}
		else
		{
			$group = Group::find($data['id']);
		}
		
		$group->title = $data['title'];
		$group->code = trim($data['code']);
		
		$old_teacher_id = $group->teacher_id;
		
		if(Auth::user()->isAdmin())
		{
			$group->teacher_id = $data['teacher_id'];
		}
		else
		{
			$group->teacher_id = Auth::user()->id;
		}
		
		$group->save();
		
		if(!$isNewEntry)
		{
			if($old_teacher_id != $group->teacher_id)
			{
				$old_user = User::find($old_teacher_id);
				if($old_user->isInGroup($group->id))
				{
					$old_user->groups()->detach($group->id);
				}
			}
		}
		
		$user = User::find($group->teacher_id);
		if(!$user->isInGroup($group->id))
		{
			$user->groups()->attach($group->id);
		}
		
		return $group->id;
	}
}
