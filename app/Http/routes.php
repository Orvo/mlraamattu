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
		$archive = App\Archive::with('user', 'test', 'test.course')->get();
		
		foreach($archive as &$row)
		{
			$row->data = json_decode($row->data);
			
			// $row->search_info = $row->data->num_correct . " oikein";
			
			if($row->data->all_correct)
			{
				$row->search_info = "kaikki oikein";
			}
		}
		
		return $archive;
	});
	
	Route::get('archive/stats', function()
	{
		$archive = App\Archive::all();
		
		return [
			'new' 		=> $archive->where('replied_to', 0)->count(),
			'total' 	=> $archive->count(),
			// 'archive'	=> $archive->,
		];
	});
	// Route::get('login', 'AuthController@ajax_login');

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