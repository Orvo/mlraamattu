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

use App\User;
use App\Contentpage;

Route::get('/', function ()
{
	$page = Contentpage::find(1);
	
	if($page)
	{
		return view('layout.contentpage', [
			'page' => $page,
		]);	
	}
	
	return redirect('/course');
});

Route::get('/home', function ()
{
	return redirect('/');
});

/**********************************************	
	Public
*/

Route::get('/test', function ()
{
	return redirect('/');
});
Route::get('test/{id}', 'TestsController@show');
Route::get('test/{id}/material', 'TestsController@material');
Route::get('test/{id}/material/popup', 'TestsController@material_popup');
Route::post('test/{id}', 'TestsController@check');

Route::get('course', 'CoursesController@index');
Route::get('course/{id}', 'CoursesController@show');

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

Route::group(['prefix' => 'groups', 'middleware' => 'auth'], function()
{
	Route::get('manage', 'GroupsController@manage');
	Route::post('manage', 'GroupsController@check');
	Route::get('leave/{id}', 'GroupsController@leave');
});

/**********************************************	
	Admin
*/

Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function()
{
	Route::get('/', function ()
	{
		return view('admin.index');
	});
});

/**********************
	Ajax Routes
**********************/

Route::get('/ajax/', function ()
{
	return redirect('/');
});

// Routes served to only ajax requests
Route::group(['middleware' => 'ajax'], function ()
{
	// Angular view templates
	Route::get('ng/{view}', function($view)
	{
		return view('ng.' . $view);
	});
	
	Route::get('ajax/auth', 'AuthController@ajax_check');
	Route::post('ajax/login', 'AuthController@ajax_login');
});

///////////////////////////////////////////////////////////////////////
// Routes that don't require elevated admin permissions

Route::group(['prefix' => 'ajax', 'middleware' => 'auth.ajax'], function()
{
	Route::get('/recent', function(App\Repositories\ArchiveEntries $entries)
	{
		$tests = App\Test::with('course', 'questions')->orderBy('updated_at', 'DESC')->limit(5)->get();
		$courses = App\Course::with('tests')->orderBy('updated_at', 'DESC')->limit(5)->get();
		
		$archive = $entries->getEntries()->where('replied_to', 0)->where('discarded', 0)->orderBy('created_at', 'ASC');
		
		$new_count = 0;
		$new_archive = [];
		foreach($archive->get() as $item)
		{
			if($item->discarded == App\Archive::NOT_DISCARDED)
			{
				$new_count++;
				if(count($new_archive) < 5)
				{
					$item->data = json_decode($item->data);
					$new_archive[] = $item;
				}
			}
		}
		
		return [
			'archive'		=> $new_archive,
			'archive_new'	=> $new_count,
			'tests' 		=> $tests,
			'courses' 		=> $courses,
		];
	});
	
	Route::get('/sessions', function()
	{
		return App\ValidSession::where('user_id', Auth::user()->id)->get();
	});
	
	Route::post('/sessions/{hash}/logout', function($hash)
	{
		$session = App\ValidSession::where('hash', $hash)->first();
		if($session)
		{
			$session->delete();
			
			return [
				'success' => true,
			];
		}
		
		return [
			'success' => false,
		];
	});
	
	Route::resource('users', 'Ajax\UsersController');
	Route::resource('groups', 'Ajax\GroupsController');
	
	Route::get('archive', 'Ajax\ArchiveController@index');
	Route::get('archive/stats', 'Ajax\ArchiveController@stats');
	Route::get('archive/{id}', 'Ajax\ArchiveController@show');
	Route::put('archive/{id}', 'Ajax\ArchiveController@store');
	Route::post('archive/{id}/discard', 'Ajax\ArchiveController@discard');
});

///////////////////////////////////////////////////////////////////////
// Routes that require admin permissions

Route::group(['prefix' => 'ajax', 'middleware' => 'auth.ajax:admin'], function()
{
	Route::resource('courses', 		'Ajax\CoursesController');
	Route::resource('questions', 	'Ajax\QuestionsController');
	Route::resource('tests', 		'Ajax\TestsController');
	Route::resource('pages', 		'Ajax\PagesController');
});

///////////////////////////////////////////////////////////////////////
// Must be last because it'll overwrite everything

Route::get('{tag}', function($tag)
{
	$page = Contentpage::where('tag', $tag)->firstOrFail();
	
	return view('layout.contentpage', [
		'page' => $page,
	]);
});

Route::get('page/{id}/{tag}', function($id, $tag)
{
	$page = Contentpage::where('id', $id)->orWhere('tag', $tag)->firstOrFail();
	
	return view('layout.contentpage', [
		'page' => $page,
	]);
});