<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('email')->unique();
            $table->string('image')->nullable();
            $table->string('password');
            $table->string('first_surname')->nullable();
            $table->string('last_surname')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('telephone')->nullable();
            $table->enum('gender', ['masculino', 'femenino'])->nullable();
            $table->date('birthdate')->nullable();
            $table->string('schedule')->nullable();
            $table->string('description')->nullable();
            $table->boolean('seller')->nullable();
            $table->integer('balance')->default(0);
            $table->string('web')->nullable();
            $table->boolean('active')->default(false);
            $table->string('activation_token');
            $table->string('social_id')->nullable();
            $table->enum('provider_access', ['ecommerce', 'google', 'facebook','twitter'])->default('ecommerce')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
        Schema::dropIfExists('users');
    }
}
