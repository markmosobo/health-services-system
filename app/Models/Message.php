<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Chat;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'subject', 'sent_to_id', 'sender_id','reply','status'];

        // A message belongs to a sender
        public function sender()
        {
            return $this->belongsTo(User::class, 'sender_id');
        }
    
        // A message also belongs to a receiver    
        public function receiver()
        {
            return $this->belongsTo(User::class, 'sent_to_id');
        }

        //A message has chats
        public function chat()
        {
            return $this->hasMany(Chat::class);
        }
}
