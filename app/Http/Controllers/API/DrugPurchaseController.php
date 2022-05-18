<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DrugPurchase;

class DrugPurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        $user = auth('api')->user();
        $drugpurchases = DrugPurchase::latest()->with('patient','drug')
        ->where('pharm_user_id',$user->id)->paginate(10);
        return response()->json($drugpurchases);
    }

    public function store(Request $request){
        $user = auth('api')->user();
       return DrugPurchase::create([
        'patient_id' => $request['patient_id'],
        'pharm_user_id' => $user->id,
        'purchaseddrug_id' => $request['purchaseddrug_id']           
       ]);
    }

    public function countDrugPurchases(){
        $user = auth('api')->user();
        $drugpurchases = DrugPurchase::all()->where('pharm_user_id',$user->id)->count();
        return response()->json($drugpurchases);
    }
    
    public function countPendingDrugSales(){
        $pendingdrugsales = DrugPurchase::all()->where('status','0')->count();
        return response()->json($pendingdrugsales);
    }
}
