<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\LabTest;

class LabFinding extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id','lab_user_id','lab_tested_id','results', 'status'];

        // A lab test belongs to a patient
        public function patient()
        {
            return $this->belongsTo(Patient::class,'patient_id');
        }

        // A lab result belongs to a doctor or a nurse
        public function user()
        {
            return $this->belongsTo(User::class,'lab_user_id');
        } 
        
        public function tested()
        {
            return $this->belongsTo(LabTest::class,'lab_tested_id');
        }
}
