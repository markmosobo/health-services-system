<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->foreign('patient_id')
                    ->references('id')
                    ->on('patients');
            $table->integer('doctor_id')->unsigned();
            $table->foreign('doctor_id')
                    ->references('id')
                    ->on('users');
            $table->longText('symptoms')->nullable();
            $table->integer('lab_test_id')->unsigned();
            $table->foreign('lab_test_id')
                    ->references('id')
                    ->on('lab_tests');
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
        Schema::dropIfExists('consultations');
    }
}
