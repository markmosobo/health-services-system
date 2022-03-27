<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\User;

class Consultation extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'symptoms',
        'status',
        'tests'
    ];

    public function setTestAttribute($value)
    {
        $this->attributes['tests'] = json_encode($value);
    }

    public function getTestAttribute($value)
    {
        return $this->attributes['tests'] = json_decode($value);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
