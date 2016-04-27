<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Contentpage;

class PagesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$pages = Contentpage::all();
		return $pages;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		abort_unauthorized();
		
		$validation = $this->_validate($request->all());
		
		$data = $validation->data;
		$data['errors'] = $validation->errors;
		
		if($validation->passed)
		{
			$data['page_created'] = $this->_save($data);
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
		$page = Contentpage::findOrFail($id);
		return $page;
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
			$data['page_edited'] = $this->_save($data);
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
		$page = Contentpage::findOrFail($id);
		
		if($page && $id != 1)
		{
			$page->delete();
			
			return [
				'success' => true,
			];
		}
		
		return [
			'success' => false,
		];
	}
	
	protected function _tagify($input)
	{
		$input = strtolower($input);
		$input = strtr($input, "åäö ", "aao-");
		$input = preg_replace('/[^a-zA-Z0-9\-]/g', '', $input);
		
		return $input;
	}
	
	protected function _validate($data)
	{
		$errors = [
			'messages' => [],
			'fields' => [],
		];
		
		$isNewEntry = !array_key_exists('id', $data);
		
		if(!@$data['title'] || strlen(trim($data['title'])) == 0)
		{
			$errors['messages'][] = "Sivun otsikko puuttuu!";
			$errors['fields']['page_title'] = true;
		}
		
		if((!@$data['tag'] || strlen(trim($data['tag'])) == 0) && strlen(trim(@$data['title'])) > 0)
		{
			$data['tag'] = $this->_tagify($data['title']);
		}
		
		if(!Contentpage::isUniqueTag($data['tag'], @$data['id']))
		{
			$errors['messages'][] = "Sama viite on jo käytössä!";
			$errors['fields']['page_tag'] = true;
		}
		
		if(!@$data['body'] || strlen(trim($data['body'])) == 0)
		{
			$errors['messages'][] = "Sivun sisältö puuttuu!";
			$errors['fields']['page_body'] = true;
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
		
		$page = Contentpage::findOrNew(@$data['id']);
		
		$page->title 			= $data['title'];
		$page->tag 				= $data['tag'];
		$page->body 			= $data['body'];
		$page->sidebar_body 	= $data['sidebar_body'];
		$page->sticky_sidebar 	= $data['sticky_sidebar'];
		$page->pinned 			= $data['pinned'];
		
		$page->save();
		
		return $page->id;
	}

}
