<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Http\Resources\PatientResource;

class PatientController extends Controller
{
    public function index(){
        return Patient::latest()->paginate(10);
    }

    public function list(){
        $patientslist = Patient::all();
        return PatientResource::collection($patientslist);        
    }

    public function store(Request $request){
        $this->validate($request,[
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'gender' => 'required|string'
        ]);

        return Patient::create([
          'first_name' => $request['first_name'],
          'last_name' => $request['last_name'],
          'dob' => $request['dob'],
          'gender' => $request['gender'],
          'address' => $request['address'],      
          'payment_id' => $request['payment_id'], 
        ]);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $this->validate($request,[
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'gender' => 'required|string'
        ]);

        $patient->update($request->all());
    } 
    
    public function countPatients(){
        $patients = Patient::all()->count();
        return response()->json($patients);
    }
}
