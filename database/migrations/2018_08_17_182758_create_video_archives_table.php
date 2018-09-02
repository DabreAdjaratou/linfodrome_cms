<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_archives', function (Blueprint $table) {
            $table->unsignedInteger('id')->nullable(false);
            $table->string('title',255)->nullable(false);
            $table->string('alias',255)->nullable(false);
            $table->unsignedInteger('category_id')->nullable(false);
            $table->unsignedTinyInteger('published')->nullable(false)->default(1)->comment('0 : not published, 1 : published');
            $table->unsignedTinyInteger('featured')->nullable(false)->default(0)->comment('0: not featured, 1:featured');
            $table->string('image',255)->nullable(true);
            $table->mediumtext('code')->nullable(false);
            $table->string('description',255)->nullable(true);
            $table->unsignedInteger('created_by')->comment('#foreign key usres : id of the journalist author of the video');
            $table->datetime('created_at')->nullable(false);
            $table->datetime('start_publication_at')->nullable(true);
            $table->datetime('stop_publication_at')->nullable(true);
            $table->unsignedInteger('checkout')->default(0)->comment('contains the id of user that is updating');
            $table->Text('keywords')->nullable(true)->comment('list of keywords');
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
        Schema::dropIfExists('video_archives');
    }
}
