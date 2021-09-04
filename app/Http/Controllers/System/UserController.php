<?php

namespace App\Http\Controllers;


use App\Models\System\Parameter;
use App\Models\System\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        parent::__construct(User::class);
    }

    public function store(Request $request)
    {
        $default_password = Parameter::byCode('USER_DEFAULT_PASSWORD');
        if (!$default_password)
            $default_password = '123456';
        $password = $request->get('password', $default_password);
        $request->merge(['password' => bcrypt($password)]);
        $response = parent::store($request);
        return $response;
    }

    public function update(Request $request, $id)
    {

        $user_target = User::findOrFail($id);


        if ($user_target->id !== Auth::id())
            check_required_lvl(get_user_lvl($user_target));
        if ($request->has('password'))
            $request->merge(['password' => bcrypt($request->get('password'))]);

        $response = parent::update($request, $id);
        return $response;
    }

    public function destroy(Request $request, $id)
    {
        $user_target = User::findOrFail($id);
        check_required_lvl(get_user_lvl($user_target));
        return parent::destroy($request, $id);
    }
}
