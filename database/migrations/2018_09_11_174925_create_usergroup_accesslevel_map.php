<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsergroupAccesslevelMap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usergroup_accesslevel_map', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_group_id')->nullable(false);
            $table->unsignedInteger('access_level_id')->nullable(false);
      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usergroup_accesslevel_map', function (Blueprint $table) {
            //
        });
    }
}
