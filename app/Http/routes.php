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

Route::get('make', function()
{
	// $user = new User();
	// $user->email = "temu92@gmail.com";
	// $user->password = bcrypt("asdfasdf");
	// $user->save();
});

Route::get('potato', function ()
{
	$question = \App\Question::with('answers')->find(1);
	
	return findByProperty($question->answers, 'id', 2);
});

Route::get('test/{id}', 'TestsController@show');
Route::get('test/{id}/material', 'TestsController@material');
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
			'tests' => App\Test::with('course', 'questions')->orderBy('updated_at', 'DESC')->limit(6)->get(),
			'courses' => App\Course::with('tests')->orderBy('updated_at', 'DESC')->limit(6)->get(),
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
	
	Route::get('archive', 'Ajax\ArchiveController@index');
	Route::get('archive/stats', 'Ajax\ArchiveController@stats');
	Route::get('archive/{id}', 'Ajax\ArchiveController@show');
	Route::put('archive/{id}', 'Ajax\ArchiveController@store');
	Route::post('archive/{id}/discard', 'Ajax\ArchiveController@discard');
});

Route::group(['middleware' => 'auth.ajax'], function()
{
	Route::get('ng/{view}', function($view)
	{
		return view('ng.' . $view);
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
	
	Route::get('reset/{token}', 'Auth\PasswordController@getReset');
	Route::post('reset/done', 	'Auth\PasswordController@postReset');
	
	Route::get('reset', 		'Auth\PasswordController@getEmail');
	Route::post('reset', 		'Auth\PasswordController@postEmail');
	
	Route::group(['middleware' => 'auth'], function()
	{
		Route::get('edit/', 'AuthController@edit');
		Route::post('edit/', 'AuthController@save');
	});
});