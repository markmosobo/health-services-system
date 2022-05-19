<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConsultationCharge;
use App\Http\Resources\ConsultationChargeResource;

class ConsultationChargeController extends Controller
{
    public function index()
    {
        return ConsultationCharge::latest()->paginate(1);
    }

    public function list()
    {
        $list = ConsultationCharge::all();
        return ConsultationChargeResource::collection($list);
    }

    public function store(Request $request)
    {
        $this->validate($request,
        [
            'consult_charge' => 'required'
        ]);

        return ConsultationCharge::create([
            'consult_charge' => $request['consult_charge']
        ]);
    }

    public function update(Request $request,$id)
    {
        $charge = ConsultationCharge::findOrFail($id);
        $this->validate($request,
        [
            'consult_charge' => 'required'
        ]);

        $charge->update($request->all());
    }

    public function destroy(Request $request,$id)
    {
        $charge = ConsultationCharge::findOrFail($id);
        $charge->delete();
    }
}
