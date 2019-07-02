<?php

namespace App\Http\Controllers;

use App\Events\CommentSent;
use App\Models\System\Comment;
use App\Models\System\User;
use App\Notifications\CommentNotification;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CommentController extends BaseController
{


    public function index($id){
        $comments = Comment::where('product_id', $id)->get();
        return jsend_success($comments, 202);


    }

    public function created(Request $request, $id)
    {

        $user = Auth::user();

        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->product_id = $id;
        $comment->message = $request->message;
        $comment->save();
        broadcast(new CommentSent($user, $comment))->toOthers();

        return ['status' => 'Message Sent!'];

    }

    public function delete($id){
        Comment::find($id)->delete();
        return jsend_success($id, 202,  trans("messages.models.destroy"));
    }


}
