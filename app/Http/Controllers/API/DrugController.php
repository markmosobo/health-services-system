<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drug;
use App\Http\Resources\DrugResource;

class DrugController extends Controller
{
    public function index()
    {
        return Drug::latest()->paginate(10);
    }

    public function list(){
        $list = Drug::all();
        return DrugResource::collection($list);        
    }

    public function tabletlist(){
        $list = Drug::all()->where('dose_form','tablet');
        return DrugResource::collection($list);        
    }

    public function injectionlist(){
        $list = Drug::all()->where('dose_form','injection');
        return DrugResource::collection($list);        
    }

    public function liquidlist(){
        $list = Drug::all()->where('dose_form','liquid');
        return DrugResource::collection($list);        
    }

    public function inhalationlist(){
        $list = Drug::all()->where('dose_form','inhalation');
        return DrugResource::collection($list);        
    }

    public function oralliquidlist(){
        $list = Drug::all()->where('dose_form','oral liquid');
        return DrugResource::collection($list);        
    }

    public function pfilist(){
        $list = Drug::all()->where('dose_form','pfi');
        return DrugResource::collection($list);        
    }

    public function otherlist(){
        $list = Drug::all()->where('dose_form','');
        return DrugResource::collection($list);        
    }

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'quantity' => 'required|string',
            'dose_form' => 'required|string'
        ]);

        return Drug::create([
          'name' => $request['name'],
          'quantity' => $request['quantity'],
          'dose_form' => $request->get('dose_form'),
          'price' => $request->get('price')    
        ]);
    }

    public function update(Request $request, $id)
    {
        $drug = Drug::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'dose_form' => 'required|string',
            'quantity' => 'required|string'
        ]);

        $drug->update($request->all());
    }
}
