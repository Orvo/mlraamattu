<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSidebarBodyColumnToContentpagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contentpages', function (Blueprint $table) {
			$table->text('sidebar_body')->after('body');
			$table->boolean('sticky_sidebar')->after('sidebar_body');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contentpages', function (Blueprint $table) {
			$table->dropColumn('sidebar_body');
			$table->dropColumn('sticky_sidebar');
		});
	}
}
