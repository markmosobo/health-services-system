<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Method;

class MethodController extends Controller
{
    public function index(){
        $methods = Method::latest()->paginate(10);
        return response()->json($methods);
    }

    public function store(Request $request){
        return Method::create([
            'type' => $request['type'],
            'account' => $request['account'],
        ]);
    }

    public function update(Request $request,$id){
        $method = Method::findOrFail($id);

        $method->update($request->all());
    }

    public function show(Request $request,$id){
        $method = Method::findOrFail($id);
        return response()->json($method);
    }

    public function destroy(Request $request,$id){
        $method = Method::findOrFail($id);
        $method->delete();
    }
}
