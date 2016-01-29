<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Question;
use App\User;

Route::get('/', function ()
{
	return redirect('/course');
});

Route::get('potato', function ()
{
	try
	{
		return App\Test::findOrFail(3);
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}
	
});

Route::get('make', function()
{
	// $user = new User();
	// $user->email = "temu92@gmail.com";
	// $user->password = bcrypt("asdfasdf");
	// $user->save();
});

Route::get('test/{id}', 'TestsController@show');
Route::post('test/{id}', 'TestsController@check');

Route::get('course', 'CoursesController@index');
Route::get('course/{id}', 'CoursesController@show');

Route::get('archive/{id}', function($id)
{
	return User::findOrFail($id)->archives;
});
	
Route::get('ajax/auth', function()
{
	$response = [
		'authenticated' => Auth::check() && Auth::user()->isAdmin(),
	];
	
	if($response['authenticated'])
	{
		$response['user'] = Auth::user();
	}
	
	return $response;
});

Route::post('ajax/login', 'AuthController@ajax_login');
	
Route::group(['prefix' => 'ajax', 'middleware' => 'auth.ajax'], function()
{
	Route::get('/', function ()
	{
		return redirect('/');
	});
	
	Route::get('/recent', function()
	{
		return [
			'tests' => App\Test::with('questions')->orderBy('updated_at', 'DESC')->limit(10)->get(),
			'courses' => App\Course::with('tests')->orderBy('updated_at', 'DESC')->limit(10)->get(),
		];
	});

	Route::get('/questions', function ()
	{
		$question = Question::all();
		return $question;
	});

	Route::get('/questions/{id}', function ($id)
	{
		$question = Question::with('answers')->findOrFail($id);
		return $question;
	});

	Route::resource('courses', 'Ajax\CoursesController');
	Route::resource('tests', 'Ajax\TestsController');
	Route::resource('users', 'Ajax\UsersController');
	
	Route::get('archive', function()
	{
		$archive = App\Archive::with('user', 'test', 'test.course')->has('test')->has('user')->get();
		
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
	});
	
	Route::get('archive/stats', function()
	{
		$archive = App\Archive::has('test')->get();
		
		return [
			'new' 		=> $archive->where('replied_to', 0)->where('discarded', 0)->count(),
			'total' 	=> $archive->count(),
			// 'archive'	=> $archive->,
		];
	});
	
	Route::get('archive/{id}', function($id)
	{
		$archive = App\Archive::with('user', 'test', 'test.questions', 'test.questions.answers', 'test.course')->where('id', $id)->firstOrFail();
		
		if($archive)
		{
			$archive->data = json_decode($archive->data);
			
			if($archive->data->all_correct)
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
	});
	
	Route::post('archive/{id}/discard', function($id)
	{
		$archive = App\Archive::findOrFail($id);
		
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
	});

});

Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function()
{
	Route::get('/', function ()
	{
		return view('admin.index');
	});
});


Route::group(['prefix' => 'auth'], function()
{
	Route::get('login', 'AuthController@index');
	Route::post('login', 'AuthController@login');
	Route::get('logout', 'AuthController@logout');
});