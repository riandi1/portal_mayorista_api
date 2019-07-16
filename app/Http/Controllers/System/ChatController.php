<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Store\Product;
use App\Models\System\Conversation;
use App\Models\System\Message;
use App\Models\System\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


class ChatController   extends BaseController
{
    public function indexConversation(){
        $user = Auth::user();
      //  $request->request->add(['wheres' => '[{"column": "user_sender_id", "op":"=","value":"'.$user->id.'"}]']);
        $conversations = Conversation::with('product', 'userSender', 'userReceiver')->where('user_sender_id', $user->id)->orWhere('user_receiver_id', $user->id)->get();
        return jsend_success($conversations, 202);
    }

    public function showConversation($id){
        $user = Auth::user();
        $messages = Message::with('userSender')->where('conversation_id', $id)->get();
        return jsend_success($messages, 202);
    }

    public function deleteConversation($id){
        $user = Auth::user();
        Conversation::find($id)->delete();
        return jsend_success($id, 202,  trans("messages.models.destroy"));
    }

    public function storeMessage(Request $request,$id){
        $user_seder = Auth::user();
        $product = Product::find($id);
        if(!$product)
            return jsend_error(trans("El producto no se encuentra"), 404);

        $user_receiver = User::find($request->user_receiver_id);
        if(!$user_receiver)
            return jsend_error(trans("El usuario no se encuentra"), 404);

        $conversation = Conversation::where([
            ['product_id', $product->id],
            ['user_sender_id', $user_seder->id],
            ['user_receiver_id', $user_receiver->id]
        ])
        ->orWhere([
            ['product_id', $product->id],
            ['user_receiver_id', $user_seder->id],
            ['user_sender_id', $user_receiver->id]
        ])
        ->first();



        if(!$conversation){
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


        broadcast(new MessageSent($user_receiver, $user_seder, $message))->toOthers();
       // event(new MessageSent($user_seder, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }

    public function deleteMessage($id){
        $user = Auth::user();
        Message::find($id)->delete();
        return jsend_success($id, 202,  trans("messages.models.destroy"));
    }

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
