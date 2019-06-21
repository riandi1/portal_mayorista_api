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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('image')->nullable();
            $table->string('password');
            $table->string('fcm_token')->nullable();
            $table->unsignedInteger('document_type_id');
            $table->string('document_number');
            $table->string('first_surname')->nullable();
            $table->string('last_surname')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('state_id');
            $table->unsignedInteger('city_id');
            $table->string('telephone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->enum('gender', ['masculino', 'femenino'])->nullable();
            $table->date('birthdate')->nullable();
            $table->enum('provider_access', ['Ecommerce', 'google.com', 'facebook.com'])->default('Ecommerce')->nullable();
            $table->enum('record_origin', ['Web', 'Android', 'IOs'])->default('Web')->nullable();
            $table->string('web')->nullable();
            $table->string('schedule')->nullable();
            $table->string('description')->nullable();
            $table->boolean('seller')->nullable();
            $table->integer('balance')->default(0);
            $table->boolean('accept_terms')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
            $table->unique(['document_type_id', 'document_number'], 'index_unique_user');
            $table->foreign('document_type_id')->references('id')->on('document_types')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
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
