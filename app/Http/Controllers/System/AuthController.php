<?php

namespace App\Http\Controllers;

use App\Models\System\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;
use Spatie\Permission\Exceptions\UnauthorizedException;
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

    public function restore(Request $request)
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
        }        return redirect(env('APP_FRONT_URL', 'http://104.140.246.214').'/login/resetpassword/'.$token);
    }



    public function reset(Request $request)
    {
         $request->validate([
             'email' => 'required|string|email',
             'password' => 'required|string|confirmed',
             'token' => 'required|string'
         ]);

        $passwordReset = PasswordReset::where('token', $request->token)->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'Este token de restablecimiento de contraseña no es válido.'
            ], 404);
        $user = User::where('email', $request->email)->first();
        if (!$user)
            return response()->json([
                'message' => 'No podemos encontrar un usuario con esa dirección de correo electrónico.'
            ], 404);
        $user->password = bcrypt($request->password);
        $user->active = true;
        $user->save();
        $user->notify(new PasswordResetSuccess('sss'));
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
        return redirect(env('APP_FRONT_URL', 'http://104.140.246.214').'/login');
    }

}
