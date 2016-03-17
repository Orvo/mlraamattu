<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsInGroupsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('groups', function(Blueprint $table)
		{
			$table->renameColumn('group_title', 'title');
			$table->renameColumn('group_code', 'code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('groups', function($table)
		{
			$table->renameColumn('group', 'group_title');
			$table->renameColumn('group', 'group_code');
		});
	}
}
