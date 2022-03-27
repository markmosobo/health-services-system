<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Outpatient;

class OutpatientController extends Controller
{
    public function index(){
        return Outpatient::latest()->with('lab','patient')->paginate(10);
    }

    public function store(Request $request){
        return Outpatient::create([
            'patient_id' => $request['patient_id'],
            'lab_id' => $request['lab_id']
        ]);
    }

    public function update(Request $request,$id){
        $outpatient = Outpatient::findOrFail($id);

        $outpatient->update($request->all());
    }
}
