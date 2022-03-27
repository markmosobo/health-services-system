<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;

class PatientVitals extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'weight',
        'height',
        'temperature',
        'blood_pressure'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
