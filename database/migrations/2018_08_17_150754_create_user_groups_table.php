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
            $table->unsignedInteger('parent_id')->default(0)->comment('reference the parent group using a reflexive relationship, the value is 0 when a group have not a group parent');
            $table->timestamps();
            $table->index('parent_id');
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
