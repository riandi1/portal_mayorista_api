<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageVarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_vars', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('page_id')->nullable();
            $table->string('name');
            $table->longText('value')->nullable();
            $table->enum('type', [
                'string',
                'number',
                'boolean',
                'color',
                'datetime',
                'object',
                'file'
            ])->default('string');
            $table->boolean('is_array')->default(0);
            $table->timestamps();
            $table->unique(['name', 'page_id']);
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
        Schema::dropIfExists('page_vars');
    }
}
