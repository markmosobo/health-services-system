<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Resources\PaymentResource;

class PaymentController extends Controller
{
    public function index(){
        return Payment::latest()->paginate(10);
    }

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'account_number' => 'sometimes'
        ]); 
        
        return Payment::create([
            'name' => $request['name'],
            'account_number' => $request['account_number']
        ]);
    }

    public function update(Request $request,$id){
        $payment = Payment::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'account_number' => 'sometimes'
        ]); 
        $payment->update($request->all());
        
        return (['message' => 'payment updated']);
    } 
    
    public function list(){
        $paymentlist = Payment::all();
        return PaymentResource::collection($paymentlist);        
    }
}
