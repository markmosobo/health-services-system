<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
use App\Models\Laboratory;
use App\Models\Patient;

class Inpatient extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id','room_id','lab_id','discharge_date'];

        // An inpatient belongs to a patients list
        public function patient()
        {
            return $this->belongsTo(Patient::class);
        }        
        
        // An inpatient belongs to a room
        public function room()
        {
            return $this->belongsTo(Room::class, 'room_id');
        }
    
        // An inpatient went to lab     
        public function lab()
        {
            return $this->belongsTo(Laboratory::class, 'lab_id');
        }
}