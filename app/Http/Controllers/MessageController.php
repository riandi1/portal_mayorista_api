<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Events\MessageSent;
use App\Message;
use App\Models\Store\Product;
use App\Models\System\User;
use Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function __construct()
    {
        parent::__construct(Message::class);
    }

    public function store(Request $request){}

    public function update(Request $request, $id){

       $user_seder = Auth::user();
       $product = Product::find($id);
        if($product==null)
            return jsend_fail('', 402, trans("Product not found."));

        $user_receiver = User::find($product->user_id);

        $conversation = Conversation::where([
            ['product_id', $product->id],
            ['user_sender_id', $user_seder->id],
            ['user_receiver_id', $user_receiver->id]
        ])->first();



        if($conversation==null){
            $conversation = new Conversation();
            $conversation->product_id =  $product->id;
            $conversation->user_sender_id =  $user_seder->id;
            $conversation->user_receiver_id =  $user_receiver->id;
            $conversation->save();
        }


        $message = new Message();
        $message->message = $request->message;
        $message->conversation_id = $conversation->id;
        $message->user_sender_id = $user_seder->id;
        $message->save();



        event(new MessageSent($user_seder, $message));

        return ['status' => 'Message Sent!'];
    }

    public function show(Request $request, $id){}

    /*  public function sendMessage(Request $request, $id)
      {

          $user_from = Auth::user();
          $product = Product::find($id);
          $user_to = User::find($product->user_id);

         $conversation = Conversation::where([
              ['product_id', $product->id]
          ])->first();



         if($conversation==null){
              $conversation = new Conversation();
              $conversation->product_id =  $product->id;
              $conversation->save();
          }



          $conversation->users()->sync([$user_from->id,$user_to->id]);


          $message = new Message();
          $message->message = $request->input('message');
          $message->conversation_id = $conversation->id;
          $message->sender_id = $user_from->id;
          $message->save();


         event(new MessageSent($user_from, $message));
          return ['status' => 'Message Sent!'];


      }*/
}
