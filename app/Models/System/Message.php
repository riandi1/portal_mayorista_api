<?php

namespace App\Models\System;

use App\Models\Model;


class Message extends Model
{

    protected $fillable = ['user_sender_id', 'message', 'conversation_id'];
    //protected $appends = ['is_sender'];
    protected $relationships = ['conversation', 'userSender'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function userSender()
    {
        return $this->belongsTo(User::class);
    }

  /*  public function sender()
    {
        return $this->belongsTo(User::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class);
    }*/

  /*  public function getIsSenderAttribute(){
        $user_id = \Auth::id();
        return $this->sender_id === $user_id;
    }
*/

}
