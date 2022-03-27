<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_id')->unsigned();
            $table->integer('sent_to_id')->unsigned();
            $table->text('body')->nullable();
            $table->text('subject')->nullable();
            $table->foreign('sender_id')
                  ->references('id')
                  ->on('users');
            $table->foreign('sent_to_id')
                  ->references('id')
                  ->on('users');  
            $table->text('reply')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
                });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
