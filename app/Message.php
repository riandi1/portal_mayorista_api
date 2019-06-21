<?php

namespace App;


use App\Models\Model;
use App\Models\System\User;

class Message extends Model
{

    protected $fillable = ['sender_id', 'message'];
    //protected $appends = ['is_sender'];
    protected $relationships = ['conversation', 'sender'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
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
