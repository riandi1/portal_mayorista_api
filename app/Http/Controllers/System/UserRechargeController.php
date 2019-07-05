<?php

namespace App\Http\Controllers;

use App\Models\System\UserRecharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRechargeController extends Controller
{
    public function __construct()
    {
        parent::__construct(UserRecharge::class);
    }

    public function store(Request $request){
        $user = Auth::user();
        $request->merge(['user_id' => $user->id]);
        $response = parent::store($request);
        return $response;

    }
}
