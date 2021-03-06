<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevisionArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revision_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 100)->nullable(false);
            $table->unsignedInteger('user_id')->nullable(false);
            $table->unsignedInteger('article_id')->nullable(false);
            $table->datetime('revised_at')->nullable(false);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revision_articles');
    }
}

