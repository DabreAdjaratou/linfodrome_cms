<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGroupAccessLevelMap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('userGroup_accessLevels_map', function (Blueprint $table) {
             $table->increments('id');
            $table->unsignedInteger('access_level_id')->nullable(false);
            $table->unsignedInteger('user_group_id')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userGroup_accessLevels_map');
    }
}
