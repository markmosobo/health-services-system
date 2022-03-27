<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drug;

class DrugController extends Controller
{
    public function index()
    {
        return Drug::latest()->paginate(10);
    }

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'quantity' => 'required|string'
        ]);

        return Drug::create([
          'name' => $request['name'],
          'quantity' => $request['quantity']     
        ]);
    }

    public function update(Request $request, $id)
    {
        $drug = Drug::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'quantity' => 'required|string'
        ]);

        $drug->update($request->all());
    }
}
