<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->foreign('patient_id')
                    ->references('id')
                    ->on('patients');
            $table->integer('prescribe_doctor_id')->unsigned();
            $table->foreign('prescribe_doctor_id')
                    ->references('id')
                    ->on('users');                    
            $table->integer('drug_id')->unsigned();
            $table->foreign('drug_id')
                    ->references('id')
                    ->on('drugs');
            $table->string('patient_status')->nullable();        
            $table->string('status')->default(0);        
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
        Schema::dropIfExists('prescriptions');
    }
}
