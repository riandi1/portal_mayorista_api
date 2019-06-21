<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            $table->string('password')->nullable();

            $table->enum('entry_type', ['imap', 'pop3'])->default('imap');
            $table->string('entry_server')->nullable();
            $table->string('entry_port')->nullable();

            $table->string('exit_server')->nullable();
            $table->string('exit_port')->nullable();

            $table->boolean('auth_required')->default(1);
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
        Schema::dropIfExists('emails');
    }
}
