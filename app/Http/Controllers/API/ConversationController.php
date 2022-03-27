<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Chat;

class ConversationController extends Controller
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
    
    public function sendMessage(Request $request){
        $user = auth('api')->user();
        return Message::create([
            'sender_id' => $user->id,
            'body'       => $request->body,
            'subject'    => $request->subject,
            'sent_to_id' => $request->sent_to_id,
        ]); 
    }

    public function addChat(Request $request,$id){
        $user = auth('api')->user();
        $message = Message::findOrFail($id);
        $chat = Chat::create([
            'user_id' => $user->id,
            'message_id' => $message->id,
            'reply' => $request->chat_info
        ]);

        $chat->save();
    }

    public function fetchChat(){
        $chats =  Chat::orderBy('created_at','asc')->paginate(1000);
        return response()->json($chats);
    }
}
