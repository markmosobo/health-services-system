<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LabTest;

class LabTestBill extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'patient_id',
        'lab_test_id'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id');
    }

    //A bill belongs to a lab test
    public function test()
    {
        return $this->belongsTo(LabTest::class,'lab_test_id');
    } 
   
}
