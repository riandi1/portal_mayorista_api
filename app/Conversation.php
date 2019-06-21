<?php

namespace App;

use App\Models\Model;
use App\Models\Store\Product;
use App\Models\System\User;

class Conversation extends Model
{
    protected $relationships = ['product', 'messages', 'userSender','userReceiver'];
    protected $fillable = ['id', 'product_id','user_receiver_id','user_sender_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function userSender(){
        return $this->belongsTo(User::class);
    }

    public function userReceiver(){
        return $this->belongsTo(User::class);
    }


    /*  public function users()
      {
          return $this->belongsToMany(User::class, 'user_conversation');
      }*/

}
