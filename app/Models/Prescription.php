<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Patient;

class Prescription extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id','prescribe_doctor_id','prescription','status'];

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
}
