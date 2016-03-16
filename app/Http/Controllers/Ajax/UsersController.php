<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use \Auth;
use \Hash;
use Mail;

class UsersController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$users = User::with('archives')->get();
		
		foreach($users as &$user)
		{
			if($user->isAdmin())
			{
				$user->misc_info = "ylläpitäjä|admin";
			}
			else
			{
				$user->misc_info = "käyttäjä";
			}
			
			if(!$user->tests_completed)
			{
				$user->tests_completed = 0;
			}
			
			foreach($user->archives as $archive)
			{
				$data = json_decode($archive->data);
				if($data->all_correct)
				{
					$user->tests_completed += 1;
				}
			}
		}
		
		return $users;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
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
			$data['user_created'] = $this->_save($data);
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
		$user = User::findOrFail($id);
		
		return $user;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		
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
			$data['user_edited'] = $this->_save($data);
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
		$user = User::findOrFail($id);
		
		if($user && Auth::user()->id != $id)
		{
			$user->archives()->delete();
			$user->delete();
			
			return [
				'success' => true,
			];
		}
		
		return [
			'success' => false,
		];
	}
	
	protected function _validate($data)
	{
		$errors = [
			'messages' => [],
			'fields' => [],
		];
		
		$isNewEntry = !array_key_exists('id', $data);
		
		if(!@$data['name'] || strlen(trim($data['name'])) == 0)
		{
			$errors['messages'][] = "Käyttäjän nimi puuttuu!";
			$errors['fields']['user_name'] = true;
		}
		
		if(!@$data['email'] || strlen(trim($data['email'])) == 0)
		{
			$errors['messages'][] = "Käyttäjän sähköposti puuttuu!";
			$errors['fields']['user_email'] = true;
		}
		if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
		{
			$errors['messages'][] = "Sähköposti ei ole pätevä!";
			$errors['fields']['user_email'] = true;
		}
		else
		{
			if(($isNewEntry && User::where('email', $data['email'])->exists()) ||
			   (!$isNewEntry && User::where('email', $data['email'])->where('id', '!=', @$data['id'])->exists()))
			{
				$errors['messages'][] = "Käyttäjä samalla sähköpostiosoitteella on jo olemassa.";
				$errors['fields']['user_email'] = true;
			}
		}
		
		if(@$data['password'] && strlen($data['password']) > 0)
		{
			if(strlen($data['password']) < 8)
			{
				$errors['messages'][] = "Salasanan tulee olla vähintään 8 merkkiä pitkä.";
				$errors['fields']['user_password'] = true;
			}
			elseif($data['password'] != @$data['password_confirmation'])
			{
				$errors['messages'][] = "Salasanat eivät täsmää.";
				$errors['fields']['user_password'] = true;
			}
		}
		elseif($isNewEntry)
		{
			$errors['messages'][] = "Salasana puuttuu!";
			$errors['fields']['user_password'] = true;
		}
		elseif(!$isNewEntry && @$data['password'])
		{
			$user = User::find($data['id']);
			if($user && Hash::check($data['password'], $user->password))
			{
				$errors['messages'][] = "Uusi salasana on sama kuin vanha. Käytä jotain muuta salasanaa!";
				$errors['fields']['user_password'] = true;
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
			$user = new User();
			$user->change_password = true;
		}
		else
		{
			$user = User::find($data['id']);
		}
		
		$user->name = $data['name'];
		$user->email = $data['email'];
		
		if(strlen(@$data['password']) > 0)
		{
			$user->password = Hash::make($data['password']);
		}
		
		if(Auth::user()->isAdmin() && $user->id != Auth::user()->id)
		{
			$user->access_level = $data['access_level'];
		}
		
		if($isNewEntry)
		{
			Mail::send('email.admin_account_created',
			[
				'user' 		=> $user,
				'password'	=> $data['password'],
			],
			function($m) use ($user)
			{
				$m->to($user->email, $user->name)->subject('Sinulle on luotu käyttäjätunnus Media7 raamattuopistoon');
			});
		}
		elseif($user->id != Auth::user()->id)
		{
			$user->change_password = true;
			
			Mail::send('email.admin_account_edited',
			[
				'user' 		=> $user,
				'password'	=> strlen(@$data['password']) > 0 ? $data['password'] : false,
			],
			function($m) use ($user)
			{
				$m->to($user->email, $user->name)->subject('Käyttäjätietojasi on muokattu Media7 raamattuopistossa');
			});
		}
		elseif(strlen(@$data['password']) > 0)
		{
			$user->change_password = false;
		}
		
		$user->save();
		
		return $user->id;
	}

}
