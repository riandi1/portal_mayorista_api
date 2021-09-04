<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryFeacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_feactures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('type')->default('string');
            $table->boolean('required')->default(true);
            $table->unsignedInteger('category_id');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['key', 'category_id'], 'index_unique_category_feacture');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_feactures');
    }
}
