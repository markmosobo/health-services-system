<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Message;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','reply','message_id'];

    public function user()
    {
        $this->belongsTo(User::class,'user_id');
    }

    public function messages()
    {
        $this->belongsToMany(Message::class,'message_id');
    }
}
