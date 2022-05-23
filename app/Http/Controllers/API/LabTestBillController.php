<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LabTestBill;
use Illuminate\Http\Request;

class LabTestBillController extends Controller
{
    public function index()
    {
        return LabTestBill::latest()->with('patient','test')->paginate(10);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'patient_id' => 'required|integer',
            'lab_test_id' => 'required|integer'
        ]);

        return LabTestBill::create([
            'patient_id' => $request->get('patient_id'),
            'lab_test_id' => $request->get('lab_test_id')
        ]);
    }    
}
