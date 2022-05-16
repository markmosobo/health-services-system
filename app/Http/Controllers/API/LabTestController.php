<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LabTest;

class LabTestController extends Controller
{
    public function index()
    {
        return LabTest::latest()->paginate(10);
    }

    public function list()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'code' => 'required|string'
        ]);

        return LabTest::create([
            'name' => $request->get('name'),
            'code' => $request->get('code')
        ]);
    }

    public function update(Request $request,$id)
    {
        $labtest = LabTest::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|string',
            'code' => 'required|string'
        ]);
        $labtest->update($request->all());
    }

    public function destroy(Request $request,$id)
    {
        $labtest = LabTest::findOrFail($id);
        $labtest->delete();
    }
}
