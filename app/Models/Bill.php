<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'bill_no',
        'patient_id',
        'doctor_charge',
        'room_charge',
        'no_of_days',
        'lab_chargebill'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id');
    }
}
