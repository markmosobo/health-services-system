<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\User;

class DrugPurchase extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id','pharm_user_id','drugs'];

        // A drug purchase belongs to a patient
        public function patient()
        {
            return $this->belongsTo(Patient::class,'patient_id');
        }

        // A drug purchase belongs to a pharmacist
        public function pharm()
        {
            return $this->belongsTo(User::class,'pharm_user_id');
        }
}
