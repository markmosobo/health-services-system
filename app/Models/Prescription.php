<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Patient;
use App\Models\Drug;

class Prescription extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id','prescribe_doctor_id','drug_id','status'];

        // A prescription belongs to a patient
        public function patient()
        {
            return $this->belongsTo(Patient::class,'patient_id');
        }

        // A prescription belongs to a consulted doctor
        public function doctor()
        {
            return $this->belongsTo(User::class,'prescribe_doctor_id');
        }   
        
        public function drug()
        {
            return $this->belongsTo(Drug::class,'drug_id');
        }
}
