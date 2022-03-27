<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Laboratory;
use App\Models\Patient;

class Outpatient extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id','lab_id'];

    //outpatient visited a lab
    public function lab()
    {
        return $this->belongsTo(Laboratory::class,'lab_id');
    }

    //outpatient belongs to a patients list
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
