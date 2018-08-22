<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_groups', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('title',100)->nullable(false)->unique();
            $table->unsignedInteger('group_parent_id')->default(0)->nullable(false)->comment('reference the parent group using a reflexive relationship, the value is 0 when a group have not a group parent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_groups');
    }
}