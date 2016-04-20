<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valid_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hash', 50)->unique();
            $table->integer('user_id');
            $table->string('ip', 40);
            $table->string('useragent', 500);
            $table->timestamp('last_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('valid_sessions');
    }
}
