<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Archive;

use App\Repositories\TestValidator;
use Mail;

use Auth;

class ArchiveController extends Controller
{
	
	public function index()
	{
		$archive = $this->getArchiveEntries();
		
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
	
	public function getArchiveEntries()
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
	
	function stats()
	{
		$archive = $this->getArchiveEntries();
		
		return [
			'new' 		=> $archive->where('replied_to', 0)->where('discarded', 0)->count(),
			'total' 	=> $archive->count(),
		];
	}
	
	function show($id, TestValidator $testvalidator)
	{
		$archive = Archive::with('user', 'test', 'test.questions', 'test.questions.answers', 'test.course')
			->where('id', $id)->firstOrFail();
		
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
	
	function store($id, Request $request, TestValidator $testvalidator)
	{
		$archive = Archive::with('user', 'test', 'test.questions', 'test.course')
			->has('user')->has('test')
			->findOrFail($id);
		
		$feedback = [];
		foreach($request->get('feedback') as $key => $item)
		{
			$temp = htmlspecialchars(trim($item));
			if(strlen($temp) > 0)
			{
				$feedback[$key] = $temp;
			}
		}
		
		$reviewer = \Auth::user();
		
		if($archive && count($feedback) > 0)
		{
			$archive->data = json_decode($archive->data, true);
			
			if($archive->replied_to == 0)
			{
				$validation = $testvalidator->WithAnswers($archive->test, $archive->data['given_answers']);
				
				$mail_data = [
					'user' 			=> $archive->user,
					'test' 			=> $archive->test,
					'data'			=> $archive->data,
					'reviewer'		=> $reviewer,
					'feedback'		=> $feedback,
					'validation'	=> $validation['validation'],
				];
				
				// Email notification
				Mail::send('email.feedback_notification', $mail_data, function($m) use ($archive)
				{
					$m->to($archive->user->email, $archive->user->name)
					  ->subject('Koepalautetta Media7 raamattuopistolta');
				});
			}
			
			$data = $archive->data;
			$data['feedback'] = $feedback;
			
			$archive->data = json_encode($data);
			
			$archive->replied_to = 1;
			$archive->reviewed_by = $reviewer->id;
			
			$archive->discarded = 0;
			
			$archive->save();
			
			return [
				'success' => 1,
			];
		}
		elseif(count($feedback) == 0)
		{
			$errors[] = "Anna edes jotain palautetta!";
		}
		
		return [
			'success'	=> 0,
			'feedback'	=> $feedback,
			'errors'	=> $errors,
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
