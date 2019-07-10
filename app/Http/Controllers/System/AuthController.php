<?php

namespace App\Http\Controllers;

use App\Models\System\Parameter;
use App\Models\System\User;
use App\Notifications\SignupActivate;
use Carbon\Carbon;
use DateTime;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Bridge\AccessToken;
use Laravel\Passport\Passport;
use Laravel\Passport\TokenRepository;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Socialite;
use stdClass;
use App\Models\System\PasswordReset;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;

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
        $credentials['active'] = 1;
        $credentials['deleted_at'] = null;
        $_temp_user = User::where("email", "=", $credentials["email"])->first();
        if (!$_temp_user)
            return jsend_error(trans("El usuario no se encuentra"), 404);
        if (!$_temp_user->hasPermissionTo('ALLOW_LOGIN'))
            throw UnauthorizedException::forPermissions(['ALLOW_LOGIN']);
        if (!($access_token = $request->bearerToken()) || !($user = Auth::guard('api')->user())) {
            if (!Auth::attempt($credentials))
                return jsend_error(trans("El usuario no esta autorizado"), 401);
            $user = Auth::user();
            if (!$token_result = $user->createToken($user->name . " access token"))
                return jsend_error(trans("Token de usuario no creado"));
            $access_token = $token_result->accessToken;
            $message = trans("Has iniciado sesion");
            $token = $token_result->token;
        } else $message = trans('El usuario ya ha iniciado sesion');
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
        return jsend_success($response, 202, trans("Has cerrado la sesion"));
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


    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {

        $userSocial = Socialite::driver($provider)->user();
        if ($userSocial->getEmail() == null) {
            return jsend_fail('La cuenta a asociar no cuenta con un correo');
        }

        $idSocial = $provider . $userSocial->getId();
        $userAprysa = User::where('social_id', $idSocial)->first();

        if ($userAprysa == null) {

            $names = explode(" ", $userSocial->getName());
            $lastName = "";
            foreach ($names as $key => $name) {
                if ($key > 0)
                    $lastName .= $name . ' ';
            }

            $lastName = substr($lastName, 0, -1);
            $userValid = User::where([['email', $userSocial->getEmail()]])->first();
            if ($userValid != null) {
                return jsend_fail('El correo electrónico ya ha sido registrado.');
            }


            $imagen = file_get_contents($userSocial->getAvatar());
            $fecha = new DateTime();
            file_put_contents(public_path().'/storage/User-image-'.$fecha->getTimestamp().'.jpeg', $imagen);

            $user = User::create([
                "name" => $userSocial->getName(),
                "email" => $userSocial->getEmail(),
                "first_surname" => $lastName,
                "first_name" => $names[0],
                "image" => '/storage/User-image-'.$fecha->getTimestamp().'.jpeg',
                "provider_access" => $provider,
                "password" => bcrypt($idSocial),
                'activation_token' => str_random(60),
                "social_id" => $idSocial,
            ]);

            if (!$user->hasRole('seller'))
                $user->assignRole('seller');


            $user->notify(new SignupActivate($user));

            return jsend_success($user, 202, 'El usuario ha sido creado, ¡Hemos enviado por correo electrónico el enlace para confirmar su contraseña!');

        } else {
            // TODO: remenber token in login
            $credentials = $userAprysa->only(["email", "social_id"]);
            $credentials['active'] = 1;
            $credentials['deleted_at'] = null;
            $_temp_user = User::where("email", "=", $credentials["email"])->first();
            if (!$_temp_user)
                return jsend_error(trans("El usuario no se encuentra"), 404);
            if (!$_temp_user->hasPermissionTo('ALLOW_LOGIN'))
                throw UnauthorizedException::forPermissions(['ALLOW_LOGIN']);


            $_temp_user = User::where([
                ["email", $credentials["email"]],
                ['active', true],
                ['deleted_at', null]
            ])->first();
            if (!$_temp_user)
                return jsend_error(trans("El usuario no esta autorizado"), 401);

            /** @var User $userAprysa */
            $result = $userAprysa->createToken("{$userAprysa->name} access token");
            $token = $result->accessToken;
            if (!is_null($token)) {
                $message = trans("Has iniciado sesion");
                $_user = $userAprysa->toArray();
                $_user["permissions"] = $userAprysa->getAllPermissions();
                return jsend_success([
                    'user' => $_user,
                    'access_token' => $token
                ], 200, $message);
            }
            return jsend_error(trans("Token de usuario no creado"));
        }
    }



    public function create(Request $request)
    {
         $request->validate([
             'email' => 'required|string|email',
         ]);
        $user = User::where('email', $request->email)->first();
        if (!$user)
            return response()->json([
                'message' => 'No podemos encontrar un usuario con esa dirección de correo electrónico.'
            ], 404);
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => str_random(60)
            ]
        );
        if ($user && $passwordReset)
            $user->notify(
                new PasswordResetRequest($passwordReset->token)
            );
        return response()->json([
            'message' => '¡Hemos enviado por correo electrónico el enlace para restablecer su contraseña!'
        ]);
    }


    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'Este token de restablecimiento de contraseña no es válido.'
            ], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'Este token de restablecimiento de contraseña no es válido.'
            ], 404);
        }
        //return response()->json($passwordReset);
        return redirect(env('APP_FRONT_URL', 'http://104.140.246.214').'/login/resetpassword/'.$token);
    }



    public function reset(Request $request)
    {
         $request->validate([
             'email' => 'required|string|email',
             'password' => 'required|string|confirmed',
            // 'token' => 'required|string'
         ]);

       /* $passwordReset = PasswordReset::where('token', $request->token)->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'Este token de restablecimiento de contraseña no es válido.'
            ], 404);*/
        $user = User::where('email', $request->email)->first();
        if (!$user)
            return response()->json([
                'message' => 'No podemos encontrar un usuario con esa dirección de correo electrónico.'
            ], 404);
        $user->password = bcrypt($request->password);
        $user->active = true;
        $user->save();
       // $passwordReset->delete();
        $user->notify(new PasswordResetSuccess('sss'));//$passwordReset
        //return response()->json($user);
        return jsend_success($user, 202, trans("Usted ha cambiado su contraseña con éxito"));

    }

    public function change(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user)
            return response()->json([
                'message' => 'No podemos encontrar un usuario con esa dirección de correo electrónico.'
            ], 404);

        if (!Hash::check($request->current_password, Auth::user()->password))
            return jsend_error(trans("La contraseña actual es incorrecta"), 401);


        if ($request->password!=$request->password_confirmation)
            return jsend_error(trans("Las contraseñas no coinciden"), 401);

        $user->password = bcrypt($request->password);
        $user->save();

        $user = Auth::user();
        $token = $user->token();
        $revoked = $token->revoke();
        $deleted = $token->delete();
        $response['user'] = $user;
        //return jsend_success($response, 202, trans("Se ha cambiado la contraseña, por favor inicie sesion nuevamente"));
        return redirect(env('APP_FRONT_URL', 'http://104.140.246.214').'/login');
    }

}
