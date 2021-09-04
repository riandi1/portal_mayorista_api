<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductFeacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_feactures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('value');
            $table->unsignedInteger('product_id');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['key', 'product_id'], 'index_unique_product_feacture');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_feactures');
    }
}
