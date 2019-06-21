<?php

namespace App\Http\Controllers;

use App\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function __construct()
    {
        parent::__construct(Conversation::class);
    }


    public function index(Request $request)
    {
        $user = Auth::user();
        $request->request->add(['wheres' => '[{"column": "user_sender_id", "op":"=","value":"'.$user->id.'"}]']);
        return $response = parent::index($request);
    }


    public function show(Request $request, $id)
    {
        $user = Auth::user();
        return $response = parent::show($request, $id);
    }


    public function store(Request $request){}
    public function update(Request $request, $id){}



}
