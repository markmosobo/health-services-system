<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabFindingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_findings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->foreign('patient_id')
                    ->references('id')
                    ->on('patients');                   
            $table->integer('lab_user_id')->unsigned();
            $table->foreign('lab_user_id')
                    ->references('id')
                    ->on('users');
            $table->integer('lab_tested_id')->unsigned();
            $table->foreign('lab_tested_id')
                    ->references('id')
                    ->on('lab_tests');
            $table->string('results')->nullable();
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
        Schema::dropIfExists('lab_findings');
    }
}
