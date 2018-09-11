<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourceActionMap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resource_action_map', function (Blueprint $table) {
          $table->increments('id');
            $table->unsignedInteger('resource_id')->nullable(false);
            $table->unsignedInteger('action_id')->nullable(false);
        });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resource_action_map', function (Blueprint $table) {
            //
        });
    }
}
