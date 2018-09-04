<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(false); 
            $table->string('email',100)->nullable(false)->unique();
            $table->string('password',100)->nullable(false);
            $table->rememberToken();
            $table->unsignedTinyInteger('is_active')->nullable(false)->default(1)->comment('0: inactive, 1:active');
            $table->string('image',255)->nullable(true);
            $table->unsignedTinyInteger('require_reset')->nullable(false)->default(1)->comment('0: require to reset password at the next login');
            $table->json('data')->nullable(true)->comment('contains user title,facebook,twitter,google in a json format');
            $table->timestamps();
            $table->index(['password','email','is_active']);
            $table->index('require_reset');
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
