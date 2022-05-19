<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConsultationBill;

class ConsultationBillController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'patient_id' => 'required|integer',
            'consult_charge_id' => 'required|integer'
        ]);

        return ConsultationBill::create([
            'patient_id' => $request->get('patient_id'),
            'consult_charge_id' => $request->get('consult_charge_id')
        ]);
    }
}
