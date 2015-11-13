<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Test;

class TestsController extends Controller
{
	
	public function show($id)
	{
		$test = Test::findOrFail($id);
		
		return view('test.show')
				->with([
					'test' => $test,
				]);
	}
	
	public function check($id)
	{
		$test = Test::findOrFail($id);
		
		return view('test.show')
				->with([
					'test' => $test,
				]);
	}

}
