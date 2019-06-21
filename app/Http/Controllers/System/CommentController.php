<?php

namespace App\Http\Controllers;

use App\Models\System\Comment;
use App\Models\System\User;
use App\Notifications\CommentNotification;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        parent::__construct(Comment::class);
    }

    public function store(Request $request)
    {
        $request->merge([
            'user_id' => Auth::id()
        ]);
        $response = parent::store($request);
        $array = $response->getData(true);
        if ($array['status'] === 'success') {
            $id = $array['data']['id'];
            /** @var Comment $comment */
            $comment = Comment::with(Comment::$_relations)->findOrFail($id);
            return jsend_success($comment);
        }
        return $response;
    }

    public function update(Request $request, $id)
    {
        $response = parent::update($request, $id);
        $array = $response->getData(true);
        if ($array['status'] === 'success') {
            $id = $array['data']['id'];
            /** @var Comment $comment */
            $comment = Comment::with(Comment::$_relations)->findOrFail($id);
            return jsend_success($comment);
        }
        return $response;
    }

    public function destroy(Request $request, $id)
    {
        $response = parent::destroy($request, $id);
        $array = $response->getData(true);
    }
}
