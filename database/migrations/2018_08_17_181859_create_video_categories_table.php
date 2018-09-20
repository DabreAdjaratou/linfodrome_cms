<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_categories', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('title',100)->nullable(false)->unique();
            $table->string('alias',100)->nullable(false);
            $table->tinyInteger('published')->nullable(false)->default(0)->comment('0 : not published, 1 : published');
            $table->timestamps();
            $table->index('published');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_categories');
    }
}
