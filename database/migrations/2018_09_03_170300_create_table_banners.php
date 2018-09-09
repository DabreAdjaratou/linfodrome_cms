<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBanners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100)->nullable(false);
            $table->string('alias',100)->nullable(false);
            $table->tinyInteger('published')->nullable(false)->default(0)->comment('0 : not published, 1 : published');
            $table->integer('category_id');
            $table->tinyInteger('type')->comment('0 : image, 1 : customized');
            $table->json('image')->comment('desktop,tablet and mobile images');
            $table->json('size')->comment('height and width');
            $table->string('url');
            $table->json('code');
            $table->datetime('start_publication_at')->nullable(true);
            $table->datetime('stop_publication_at')->nullable(true);
            $table->integer('created_by');
            $table->timestamps();
            $table->index(['published','start_publication_at','stop_publication_at'],'banners_publication_time');
                   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
