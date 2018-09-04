<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBilletSources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('billet_sources', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('title',100)->nullable(false)->unique();
            $table->tinyInteger('published')->nullable(false)->default(0)->comment('0 : not published, 1 : published');
            $table->timestamps();
            $table->index('published');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billet_sources');
    }
}
