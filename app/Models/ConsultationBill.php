<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\ConsultationCharge;

class ConsultationBill extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'patient_id',
        'consult_charge'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id');
    }

    //A bill belongs to a consultation session
    public function consult()
    {
        return $this->belongsTo(ConsultationCharge::class,'consult_charge_id');
    }    
}
