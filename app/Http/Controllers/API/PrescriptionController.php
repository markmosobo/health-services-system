<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prescription;

class PrescriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function index(){
        $user = auth('api')->user();
        $prescriptions = Prescription::latest()->with('patient','drug')
        ->where('prescribe_doctor_id',$user->id)->paginate(10);
        return response()->json($prescriptions);
    }

    public function bill(){
        $prescriptions = Prescription::latest()->with('patient','drug')
        ->paginate(10);
        return response()->json($prescriptions);
    }

    public function pendingPrescribe()
    {
        $labs = Prescription::latest()->with('patient','drug')->where('status', 0)->paginate(10);
        return response()->json($labs);        
    }

    public function directpendingPrescribe(Request $request)
    {
        $user = auth('api')->user();
        return Prescription::create([
            'prescribe_doctor_id' => $user->id,
            'patient_id' => $request->get('patient_id'),
            'drug_id' => $request->get('drug_id'),
            'patient_status' => 'outpatient'
        ]);        
    }

    public function store(Request $request)
    {
        $user = auth('api')->user();
       return Prescription::create([
        'patient_id' => $request['patient_id'],
        'prescribe_doctor_id' => $user->id,
        'patient_status' => $request->get('patient_status'),
        'drug_id' => $request['drug_id']           
       ]);
    }

    public function update(Request $request,$id){
        $prescription = Prescription::findOrFail($id);

        if($prescription){
            $prescription->update(array('status' => 1));
            $prescription->save();
        }
    }

    public function countPrescriptions(){
        $user = auth('api')->user();
        $prescription = Prescription::all()->where('status','1')->where('prescribe_doctor_id',$user->id)->count();
        return response()->json($prescription);
    }

    public function countPendingPrescriptions(){
        $pendingpreps = Prescription::all()->where('status','0')->count();
        return response()->json($pendingpreps);
    }

    public function completedPrescriptions(){
        $user = auth('api')->user();
        $prescription = Prescription::latest()->with('patient','drug')->where('status', 1)->where('prescribe_doctor_id',$user->id)->paginate(2);
        return response()->json($prescription);        
    }
}
