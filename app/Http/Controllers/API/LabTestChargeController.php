<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LabTest;

class LabTestChargeController extends Controller
{
    public function index()
    {
        return LabTest::latest()->paginate(10);
    }

    public function update(Request $request,$id)
    {
        $charge = LabTest::findOrFail($id);
        $this->validate($request,
        [
            'lab_test_charge' => 'required'
        ]);

        $charge->update([
            'charge' => $request->get('lab_test_charge')
        ]);
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $charge = LabTest::findOrFail($id);
        $charge->delete();
    }     
}
