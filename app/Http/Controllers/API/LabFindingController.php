<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LabFinding;

class LabFindingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function index(){
        $user = auth('api')->user();
        $labs = LabFinding::latest()->with('patient')
        ->where('lab_user_id',$user->id)->paginate(10);
        return response()->json($labs);
    }

    public function labFindings()
    {
        $labs = LabFinding::latest()->with('patient')->where('status', 0)->paginate(10);
        return response()->json($labs);        
    }

    public function store(Request $request)
    {
        $user = auth('api')->user();
        return LabFinding::create([
        'patient_id' => $request['patient_id'],
        'lab_user_id' => $user->id,
        'tests' => $request['tests'],
        'results' => $request['results'] 
        ]);
               
    }

    public function update(Request $request,$id){
        $labfinding = LabFinding::findOrFail($id);

        if($labfinding){
            $labfinding->update(array('status' => 1));
            $labfinding->save();
        }
    } 

    public function countLabFindings(){
        $user = auth('api')->user();
        $labs = LabFinding::all()->where('lab_user_id',$user->id)->count();
        return response()->json($labs);
    }
    
    public function countPendingLabFindings(){
        $pendinglabfindings = LabFinding::all()->where('status','0')->count();
        return response()->json($pendinglabfindings);
    }

    public function completedLabFindings(){
        $user = auth('api')->user();
        $labfinding = LabFinding::latest()->with('patient')->where('status', 1)->where('lab_user_id',$user->id)->paginate(2);
        return response()->json($labfinding);        
    }
}
