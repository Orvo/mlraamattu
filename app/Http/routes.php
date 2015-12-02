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
	echo App\Test::find(2)->isUnlocked();
});

Route::get('make', function()
{
	// $user = new User();
	// $user->email = "temu92@gmail.com";
	// $user->password = bcrypt("asdfasdf");
	// $user->save();
});

Route::group(['prefix' => 'course'], function()
{
	Route::get('/', function()
	{
		return view('course.list', [
			'courses' => App\Course::all(),
		]);
	});

	Route::get('{id}', function($id)
	{
		$user_completed = [];
		if(\Auth::check())
		{
			foreach(\Auth::user()->archives as $item)
			{
				$user_completed[$item->test_id] = json_decode($item->data);
			}
		}
		
		$course = App\Course::with('tests')->findOrFail($id);

		return view('course.tests', [
			'course' => $course,
			'user_completed' => $user_completed,
		]);
	});
});

Route::get('test/{id}', 'TestsController@show');
Route::post('test/{id}', 'TestsController@check');

Route::get('archive/{id}', function($id)
{
	return User::findOrFail($id)->archives;
});

Route::group(['prefix' => 'ajax', 'middleware' => 'auth.ajax'], function()
{
	Route::get('/', function ()
	{
		return redirect('/');
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