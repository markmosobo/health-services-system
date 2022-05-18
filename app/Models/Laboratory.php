<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\LabTest;

class Laboratory extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id','consult_doctor_id','lab_test_id','status'];

        // A lab test belongs to a patient
        public function patient()
        {
            return $this->belongsTo(Patient::class,'patient_id');
        }

        // A lab test belongs to a consulted doctor
        public function doctor()
        {
            return $this->belongsTo(User::class,'doctor_id');
        } 

        // A lab test belongs to a lab test
        public function test()
        {
            return $this->belongsTo(LabTest::class,'lab_test_id');
        }

}
