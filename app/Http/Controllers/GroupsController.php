<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Session;
use App\Group;

class GroupsController extends Controller
{
	public function manage()
	{
		return view('groups.manage')
			->with('groups', Auth::user()->groups);
	}
	
	public function check(Request $request)
	{
		$code = trim($request->get('group-code'));
		
		$errors = new MessageBag;
		
		$user = Auth::user();
		
		if($code == '')
		{
			$errors->add('error', "Syötä koodi!");
		}
		elseif($user->groups()->where('code', $code)->exists())
		{
			$errors->add('error', "Olet jo liittynyt tähän ryhmään.");
		}
		else
		{
			$group = Group::where('code', $code)->first();
			if($group)
			{
				$user->groups()->attach($group->id);
				
				return view('groups.manage')
						->with([
							'groups' 	=> $user->groups,
							'success' 	=> true,
							'group'		=> $group,
						]);
			}
			else
			{
				$errors->add('error', "Ryhmää ei löytynyt.");
			}
		}
		
		return redirect()->back()
			->with([
				'groups' => $user->groups
			])
			->withInput($request->all())
			->withErrors($errors);
	}
	
	public function leave($id)
	{
		$group = Group::find($id);
		
		if($group && Auth::user()->groups()->where('id', $id)->exists())
		{
			$user = Auth::user()->groups()->detach($id);
			
			Session::flash('group_left', true);
			
			return redirect('/groups/manage');
		}
		
		return redirect('/groups/manage');
	}
}
