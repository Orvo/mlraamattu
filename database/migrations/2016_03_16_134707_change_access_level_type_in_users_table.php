<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use \App\User;

class ChangeAccessLevelTypeInUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$users = User::all();
		$levels = [];
		
		foreach($users as $user)
		{
			$levels[$user->id] = $user->access_level;
		}
		
		DB::statement('ALTER TABLE users MODIFY COLUMN access_level VARCHAR(20)');
		
		foreach($levels as $id => $level)
		{
			$user = User::find($id);
			$user->access_level = $level == 0 ? 'USER' : 'ADMIN';
			$user->save();
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$users = User::all();
		$levels = [];
		
		foreach($users as $user)
		{
			$levels[$user->id] = $user->access_level;
		}
		
		DB::statement('ALTER TABLE users MODIFY COLUMN access_level INTEGER(11) NOT NULL');
		
		foreach($levels as $id => $level)
		{
			$user = User::find($id);
			$user->access_level = $level == 'ADMIN' ? 1 : 0;
			$user->save();
		}
	}
}
