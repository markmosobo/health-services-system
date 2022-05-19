<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationCharge extends Model
{
    use HasFactory;
    protected $fillable = [
        'consult_charge'
    ];
}
