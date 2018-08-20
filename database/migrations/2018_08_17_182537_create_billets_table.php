<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBilletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ontitle',255);
            $table->string('title',255)->nullable(false);
            $table->string('alias',255)->nullable(false);
            $table->unsignedInteger('category_id')->nullable(false);
            $table->unsignedTinyInteger('published')->nullable(false)->default(0)->comment('0 : not published, 1 : published, 2 : draft , 3: trash');
            $table->unsignedTinyInteger('featured')->nullable(false)->default(0)->comment('0: not featured, 1:featured');
            $table->string('image',255);
            $table->string('image_legend',255);
            $table->mediumtext('video');
            $table->json('gallery_photo');
            $table->mediumtext('introtext')->nullable(false);
            $table->mediumtext('fulltext')->nullable(false);
            $table->unsignedTinyInteger('source_id')->nullable(false);
            $table->Text('keywords')->comment('list of keywords');
            $table->unsignedInteger('created_by')->nullable(false)->comment('# foreign key users');
            $table->datetime('created_at')->nullable(false);
            $table->datetime('start_publication_at');
            $table->datetime('stop_publication_at datetime');
            $table->unsignedInteger('checkout')->default(0)->comment('contains the id of user that is updating');
            $table->unsignedBigInteger('views')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billets');
    }
}
