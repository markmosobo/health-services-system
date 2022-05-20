<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DrugBill;
use Illuminate\Http\Request;

class DrugBillController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'patient_id' => 'required|integer',
            'drug_id' => 'required|integer'
        ]);
        return DrugBill::create([
            'patient_id' => $request->get('patient_id'),
            'drug_id' => $request->get('drug_id')
        ]);

    }
}
