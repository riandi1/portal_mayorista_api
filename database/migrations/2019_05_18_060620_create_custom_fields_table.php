<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomFieldsTable extends Migration
{
    public function up()
    {
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model');
            $table->string('name');
            $table->string('type')->nullable()->default('text');
            $table->boolean('required')->nullable()->default(false);
            $table->json('allow')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('custom_fields');
    }
}
