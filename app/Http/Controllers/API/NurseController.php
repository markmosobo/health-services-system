<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class NurseController extends Controller
{
    public function index(){
        return User::latest()->where('role','=','nurse')->paginate(10);
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
          'role' => 'nurse',
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
