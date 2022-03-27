<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\DoctorResource;

class DoctorController extends Controller
{
    public function index(){
        return User::latest()->where('role','=','doctor')->paginate(10);
    }

    public function list(){
        $doctorslist = User::all();
        return DoctorResource::collection($doctorslist);
    }    

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6'
        ]);

        return User::create([
          'name' => $request['name'],
          'email' => $request['email'],      
          'role' => 'doctor',
        //   'bio' => $request['bio'],      
        //   'photo' => $request['photo'],      
          'password' => Hash::make($request['password']),      
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|string|min:6'
        ]);

                //hash new password
        if(!empty($request->password)){
         $request->merge(['password' => Hash::make($request['password'])]);
            }

        $user->update($request->all());
    }
}
