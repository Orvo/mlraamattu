<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscardedColumnToArchive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('archive', function (Blueprint $table) {
            $table->boolean('discarded')->after('replied_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('archive', function (Blueprint $table) {
            $table->dropColumn('discarded');
        });
    }
}
