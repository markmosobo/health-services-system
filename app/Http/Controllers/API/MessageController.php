<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
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
  
        $user = auth('api')->user();
        $messages = Message::latest()->with('sender','receiver');
        $usermessages = $messages->where('sent_to_id',$user->id)->paginate(10);
        $messages = $usermessages;
        return response()->json($messages);
    }

    public function indexsent(){
  
      $user = auth('api')->user();
      $messages = Message::latest()->with('sender','receiver');
      $usermessages = $messages->where('sender_id',$user->id)->paginate(10);
      $sentmessages = $usermessages;
      return response()->json($sentmessages);
    }   
    
    public function countMessage(){
  
      $user = auth('api')->user();
      $messages = Message::latest()->where('status', 0)->where('sent_to_id',$user->id)->count();
      return response()->json($messages);
  }

    public function store(Request $request)
    {
        // $this->validate($request,[
        //     'name' => 'required|string|max:191',
        //     'email' => 'required|string|email|max:191|unique:users',
        //     'password' => 'required|string|min:6'
        // ]);
        $user = auth('api')->user();  
        return Message::create([
          'sender_id' => $user->id,
          'sent_to_id' => $request['sent_to_id'],      
          'subject' => $request['subject'],
          'body' => $request['body'],      
        //   'photo' => $request['photo'],      
        ]);
    }

    public function update(Request $request, $id){
      $message = Message::findOrFail($id);

      $this->validate($request,[
        'reply' => 'required|string|max:191',
    ]);    


            // //update pivot table
            // $reply_ids = [];
            //     foreach ($request->get('replies') as $reply) {
            //         $existingreply = Reply::whereName($reply['text'])->first();
            //         if ($existingreply) {
            //             $reply_ids[] = $existingreply->id;
            //         } else {
            //             $newreply = Reply::create([
            //                 'body' => $reply['text']
            //             ]);
            //             $reply_ids[] = $newreply->id;
            //         }
            //     }
            // $message->replies()->sync($reply_ids); 

      $message->update($request->all());
      if(!$message->reply == ''){
        $message->update(array('status' => '1')); 
        $message->save;
        return (['message' => 'Status updated']); 
    }elseif($message->reply == ''){
        return (['message' => 'Status not updated']); 
    }
    }

    
}
