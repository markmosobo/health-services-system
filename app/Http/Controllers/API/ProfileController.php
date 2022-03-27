<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Message;
use App\Models\Chat;

class ProfileController extends Controller
{
            /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function index(){
        return auth('api')->user();
    }

    public function update(Request $request){
        $user = auth('api')->user();

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|string|min:6'
        ]);

        $currentPhoto = $user->photo;
        
        if($request->photo != $currentPhoto){
            $name = time().'.'.explode('/',explode(':', substr($request->photo, 0, strpos
            ($request->photo, ';')))[1])[1];
        \Image::make($request->photo)->save(public_path('images/').$name);
            $request->merge(['photo' => $name]);
        }

        //hash new password
        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }        
        
        $user->update($request->all());
        return ['message' => 'success'];        
    }

    public function countSent(){
        $user = auth('api')->user();
        $messages = Message::all()->where('sender_id',$user->id)->count();
        $sentmessages = $messages;
        return response()->json($sentmessages);
    }
    
    public function countReceived(){
    $user = auth('api')->user();
    $messages = Message::all()->where('sent_to_id',$user->id)->count();
    return response()->json($messages);
    }

    public function countChats(){
    $user = auth('api')->user();
    $chats = Chat::all()->where('user_id',$user->id)->count();
    return response()->json($chats);
    }
}
