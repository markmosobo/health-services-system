<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Drug;

class DrugBill extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'patient_id',
        'drug_charge_id'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id');
    }

    //A bill belongs to a drug purchase
    public function drug()
    {
        return $this->belongsTo(Drug::class,'drug_charge_id');
    }     
}
