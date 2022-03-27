<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;

class BillController extends Controller
{
    public function index(){
        $bills = Bill::latest()->with('patient')->paginate(10);
        return response()->json($bills);
    }

    public function store(Request $request){
        return Bill::create([
            'patient_id' => $request['patient_id'],
            'doctor_charge' => '500.00',
            'room_charge' => $request['room_charge'],
            'no_of_days' => $request['no_of_days'],
            'lab_chargebill' => $request['lab_chargebill']
        ]);
    }

    public function update(Request $request,$id){
        $bill = Bill::findOrFail($id);

        $bill->update($request->all());
    }

    public function show(Request $request,$id){
        $bill = Bill::findOrFail($id);
        return response()->json($bill);
    }
}
