<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ontitle',255)->nullable(true);
            $table->string('title',255)->nullable(false);
            $table->string('alias',255)->nullable(false);
            $table->unsignedInteger('category_id')->nullable(false);
            $table->unsignedTinyInteger('published')->nullable(false)->default(0)->comment('0 : not published, 1 : published, 2 : draft , 3: trash');
            $table->unsignedTinyInteger('featured')->nullable(false)->default(0)->comment('0: not featured, 1:featured');
            $table->string('image',255)->nullable(true);
            $table->string('image_legend',255)->nullable(true);
            $table->mediumtext('video')->nullable(true);
            $table->json('gallery_photo')->nullable(true);
            $table->mediumtext('introtext')->nullable(false);
            $table->mediumtext('fulltext')->nullable(false);
            $table->unsignedTinyInteger('source_id')->nullable(true);
            $table->Text('keywords')->nullable(true)->comment('list of keywords');
            $table->unsignedInteger('created_by')->nullable(false)->comment('# foreign key users');
            $table->datetime('created_at')->nullable(false);
            $table->datetime('start_publication_at')->nullable(true);
            $table->datetime('stop_publication_at')->nullable(true);
            $table->unsignedInteger('checkout')->default(0)->comment('contains the id of user that is updating');
            $table->unsignedBigInteger('views')->default(0);
            $table->index('category_id');
            $table->index(['published','start_publication_at','stop_publication_at'],'articles_publication_time');
            $table->index('featured');
            $table->index('source_id');
            $table->index('created_by');
             $table->index('views');
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
        Schema::dropIfExists('articles');
    }
}
