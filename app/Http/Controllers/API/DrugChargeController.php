<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drug;
use App\Http\Resources\DrugResource;

class DrugChargeController extends Controller
{
    public function index()
    {
        return Drug::latest()->paginate(10);
    }

    public function update(Request $request,$id)
    {
        $charge = Drug::findOrFail($id);
        $this->validate($request,
        [
            'drug_charge' => 'required'
        ]);

        $charge->update([
            'price' => $request->get('drug_charge')
        ]);
        return (['message' => 'success']);
    }

    public function destroy(Request $request,$id)
    {
        $charge = Drug::findOrFail($id);
        $charge->delete();
    }    
}
