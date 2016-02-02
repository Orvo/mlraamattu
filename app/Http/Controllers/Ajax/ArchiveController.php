<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Archive;

use App\Repositories\TestValidator;

class ArchiveController extends Controller
{
	
	public function index()
	{
		$archive = Archive::with('user', 'test', 'test.course')->has('test')->has('user')->get();
		
		foreach($archive as &$row)
		{
			$row->data = json_decode($row->data);
			
			$row->search_info = '';
			
			if($row->data->all_correct)
			{
				$row->search_info .= "kaikki oikein\n";
			}
			
			if($row->replied_to)
			{
				$row->search_info .= "vastattu\n";
			}
			
			if($row->discarded)
			{
				$row->search_info .= "hylätty\n";
			}
		}
		
		return $archive;
	}
	
	function stats()
	{
		$archive = Archive::has('test')->get();
		
		return [
			'new' 		=> $archive->where('replied_to', 0)->where('discarded', 0)->count(),
			'total' 	=> $archive->count(),
			// 'archive'	=> $archive->,
		];
	}
	
	function show($id, TestValidator $testvalidator)
	{
		$archive = Archive::with('user', 'test', 'test.questions', 'test.questions.answers', 'test.course')->where('id', $id)->firstOrFail();
		
		if($archive)
		{
			$archive->data = json_decode($archive->data, true);
			
			$archive->validation = $testvalidator->WithAnswers($archive->test, $archive->data['given_answers']);
			
			if($archive->validation['all_correct'])
			{
				$archive->search_info = "kaikki oikein";
			}
			
			$indexed_answers = [];
			
			foreach($archive->test->questions as &$question)
			{
				foreach($question->answers as $answer)
				{
					$indexed_answers[$answer->id] = $answer;
				}
				
			}
		}
		
		$archive->indexed_answers = $indexed_answers;
		
		return $archive;
	}
	
	function store($id, Request $request)
	{
		$archive = Archive::findOrFail($id);
		
		if($archive)
		{
			$archive->data = json_decode($archive->data);
			
			$feedback = $request->get('feedback');
			foreach($feedback as &$item)
			{
				$item = htmlspecialchars(trim($item));
			}
			
			$archive->data->feedback = $feedback;
			$archive->data = json_encode($archive->data);
			
			$archive->replied_to = 1;
			
			$archive->save();
			
			return [
				'success' => 1,
			];
		}
		
		return [
			'success' => 0,
		];
	}
	
	function discard($id)
	{
		$archive = Archive::findOrFail($id);
		
		if(!$archive)
		{
			return [
				'success' => false,
			];
		}
		
		$archive->discarded = 1;
		$archive->save();
		
		return [
			'success' => true,
		];
	}
}