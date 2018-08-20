<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserUsergroupMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_usergroup_map', function (Blueprint $table) {
             $table->increments('id');
            $table->unsignedInteger('user_id')->nullable(false)->comment('# foreign key users');
            $table->unsignedInteger('user_group_id')->nullable(false)->comment('# foreign key user_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_usergroup_map');
    }
}
