<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPinnedColumnToContentpagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contentpages', function (Blueprint $table) {
            $table->boolean('pinned')->default(0)->after('body');
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
            $table->dropColumn('pinned');
        });
    }
}
