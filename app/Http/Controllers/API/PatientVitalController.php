<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PatientVitals;

class PatientVitalController extends Controller
{
    public function index(){
        return PatientVitals::latest()->with('patient')->paginate(10);
    }

    public function list(){
        $patientslist = PatientVitals::all();
        return PatientResource::collection($patientslist);        
    }

    public function store(Request $request){
        $this->validate($request,[
            'patient_id' => 'required|integer',
            'weight' => 'required',
            'blood_pressure' => 'required|string'
        ]);

        return PatientVitals::create([
          'patient_id' => $request['patient_id'],
          'weight' => $request['weight'],      
          'height' => $request['height'],
          'temperature' => $request['temperature'],      
          'blood_pressure' => $request['blood_pressure'], 
        ]);
    }

    public function update(Request $request, $id)
    {
        $patient = PatientVitals::findOrFail($id);

        $this->validate($request,[
            'patient_id' => 'required|integer',
            'weight' => 'required',
            'blood_pressure' => 'required|string'
        ]);

        $patient->update($request->all());
    }

    public function destroy(Request $request, $id)
    {
        $patientvital = PatientVitals::findOrFail($id);
        $patientvital->delete();
    }

    public function countPatientVitals(){
        $patientvitals = PatientVitals::all()->count();
        return response()->json($patientvitals);
    }

}
