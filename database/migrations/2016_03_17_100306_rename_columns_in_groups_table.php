<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RenameColumnsInGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('groups', function (Blueprint $table) {
                $table->renameColumn('group_title', 'title');
                $table->renameColumn('group_code', 'code');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('groups', function (Blueprint $table) {
                $table->renameColumn('title', 'group_title');
                $table->renameColumn('code', 'group_code');
            });
        }
    }
}

