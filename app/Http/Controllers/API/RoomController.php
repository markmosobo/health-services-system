<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Http\Resources\RoomResource;

class RoomController extends Controller
{
    public function index(){
        return Room::latest()->paginate(10);
    }

    public function list(){
        $roomslist = Room::all();
        return RoomResource::collection($roomslist);        
    }

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'type' => 'required|string',
            'capacity' => 'sometimes|required'
        ]); 
        
        return Room::create([
            'name' => $request['name'],
            'type' => $request['type'],
            'capacity' => $request['capacity']
        ]);
    }

    public function update(Request $request,$id){
        $room = Room::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'type' => 'required|string',
        ]); 
        $room->update($request->all());
        
        return (['message' => 'room updated']);
    }
}
