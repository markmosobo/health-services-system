<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laboratory;
use App\Http\Resources\LaboratoryResource;

class LabController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        $labs = Laboratory::latest()->with('patient','test')->where('status', 0)->paginate(10);
        return response()->json($labs);
    }

    public function list(){
        $labslist = Laboratory::all();
        return LaboratoryResource::collection($labslist);        
    }

    public function store(Request $request){
       $user = auth('api')->user();
        // $this->validate($request,[
        //     'name' => 'required|string|max:191',
        //     'type' => 'required|string',
        // ]); 
        
        return Laboratory::create([
            'patient_id' => $request['patient_id'],
            'consult_doctor_id' => $user->id,
            'lab_test_id' => $request['lab_test_id']
        ]);        
    }

    public function update(Request $request,$id){
        $user = auth('api')->user();
        $lab = Laboratory::findOrFail($id);

        if($lab){
            $lab->update(array('status' => '1'));
            $lab->save();
        }
    }

    public function countPendingLabs(){
        $pendinglabs = Laboratory::all()->where('status','0')->count();
        return response()->json($pendinglabs);
    }

}
