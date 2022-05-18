<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\User;
use App\Models\Drug;

class DrugPurchase extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id','pharm_user_id','purchaseddrug_id'];

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

        // A drug purchase belongs to drugs
        public function drug()
        {
            return $this->belongsTo(Drug::class,'purchaseddrug_id');
        }        
}
