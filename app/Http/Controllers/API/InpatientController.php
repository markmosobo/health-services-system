<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inpatient;

class InpatientController extends Controller
{
    public function index(){
        return Inpatient::latest()->with('room','lab','patient')->paginate(10);
    }

    public function store(Request $request){
        // $this->validate($request,[
        //     'name' => 'required|string|max:191',
        //     'age' => 'required|integer|max:191',
        //     'gender' => 'required|string'
        // ]);

        return Inpatient::create([
          'patient_id' => $request['patient_id'],
          'lab_id' => $request['lab_id'],      
          'room_id' => $request['room_id'],
        ]);
    }

    public function update(Request $request, $id)
    {
        $inpatient = Inpatient::findOrFail($id);

        // $this->validate($request,[
        //     'name' => 'required|string|max:191',
        //     'age' => 'required|integer|max:191',
        //     'gender' => 'required|string'
        // ]);

        $inpatient->update($request->all());
    }
    
    public function discharge($id){
        $inpatient = Inpatient::findOrFail($id);
        $date = now();
        if($inpatient){
            $inpatient->update(array('discharge_date' => $date));
            $inpatient->save;
            return (['message' => 'success']);              
        }
    }
}
