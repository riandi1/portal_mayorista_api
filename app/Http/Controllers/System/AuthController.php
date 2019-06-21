<?php

namespace App\Http\Controllers;

use App\Models\System\Parameter;
use App\Models\System\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;
use Spatie\Permission\Exceptions\UnauthorizedException;

class AuthController extends BaseController
{
    private $tokenRepository;

    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * login
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // TODO: remenber token in login
        $credentials = $request->only(["email", "password"]);
        $_temp_user = User::where("email", "=", $credentials["email"])->first();
        if (!$_temp_user)
            return jsend_error(trans("messages.models.errors.not_found", ["model" => "User"]), 404);
        if (!$_temp_user->hasPermissionTo('ALLOW_LOGIN'))
            throw UnauthorizedException::forPermissions(['ALLOW_LOGIN']);
        if (!($access_token = $request->bearerToken()) || !($user = Auth::guard('api')->user())) {
            if (!Auth::attempt($credentials))
                return jsend_error(trans("messages.auth.errors.unauthorized"), 401);
            $user = Auth::user();
            if (!$token_result = $user->createToken($user->name . " access token"))
                return jsend_error(trans("messages.auth.errors.token_not_created"));
            $access_token = $token_result->accessToken;
            $message = trans("messages.auth.login");
            $token = $token_result->token;
        } else $message = trans('messages.auth.already_logged');
        if (!isset($token))
            $token = Auth::guard('api')->user()->token();
        $token->save(["expires_at" => Carbon::now()->addHour(env("HOURS_FOR_TOKEN_EXPIRATION"))]); // FIXME: no work

        $response["user"] = $user->toArray();
        $response["user"]["permissions"] = $user->getAllPermissions();
        $response["access_token"] = $access_token;
        return jsend_success($response, 200, $message);

    }

    /**
     * logout
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        $token = $user->token();
        $revoked = $token->revoke();
        $deleted = $token->delete();
        $response['user'] = $user;
        return jsend_success($response, 202, trans("messages.auth.logout"));
    }

    /**
     * validate user token with middleware
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function validate(Request $request)
    {
        $user = Auth::user();
        $response['user'] = $user->toArray();
        $response["user"]["permissions"] = $user->getAllPermissions();
        $response['access_token'] = $request->bearerToken();
        return jsend_success($response, 202, trans("messages.auth.valid"));
    }

    public function notifications(Request $request)
    {
        $columns = ['id', 'type', 'data', 'read_at', 'created_at'];
        $notifications = [];
        $pagination = null;

        if ($user = Auth::user()) {
            $query = $user->notifications();
            if ($request->has('paginator')) {
                $paginator = json_decode($request->get('paginator', '{"page":0}'), true);
                if (!isset($paginator['per_page']))
                    $paginator['per_page'] = intval(Parameter::byCode('LIST__PER_PAGE', true, '15'));
                $data_paginated = $query->paginate($paginator['per_page'], $columns, null, $paginator['page']);
                $notifications = $data_paginated->items();
                $pagination = collect($data_paginated)->except(['data']);
            } else
                $notifications = $query->get($columns);
        }
        return jsend_success($notifications, 200, null, [], $pagination);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function readNotifications(Request $request)
    {
        $ids = $request->get('notifications');
        $notifications = Auth::user()->notifications();
        foreach ($ids as $id) {
            try {
                $notifications->findOrFail($id)->markAsRead();
            } catch (\Exception $exception) {
                continue;
            }
        }
        $message = trans('messages.request.process_success');
        return jsend_success($notifications->get(['id', 'type', 'data', 'read_at', 'created_at']), 202, $message);
    }

    /**
     * @param Request $request
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function setFCM(Request $request, $token)
    {
        Auth::user()->fill(['fcm_token' => $token])->saveOrFail();
        return jsend_success(Auth::user(), 201, null);
    }
}
