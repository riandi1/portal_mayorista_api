<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
class SmsController extends BaseController
{
    public function sendSms(Request $request)
    {
        $request->validate([
            'telephone' => 'required|numeric|digits_between:7,15',
            'extension' => 'required'
        ]);

        //Your Account SID and Auth Token from twilio.com/console
        $sid    = env( 'TWILIO_SID' );
        $token  = env( 'TWILIO_TOKEN' );
        $client = new Client( $sid, $token );

        $user = Auth::user();
        $code = mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9);


        $message = 'Su código de confirmación Aprysa es '.$code;
        $user->activation_telephone=$code;
        $user->extension = $request->extension;
        $user->telephone = $request->telephone;
        $user->save();
        $number = $user->extension.$user->telephone;
        $client->messages->create(
            $number,
            [
                'from' => env( 'TWILIO_FROM' ),
                'body' => $message,
            ]
        );

        return jsend_success($user, 202, 'Por favor ingrese el código de verificación que le enviamos a su teléfono.');
    }

    public function active(Request $request){

        $user = Auth::user();
        if ($user->activation_telephone!=$request->activation_telephone)
            return jsend_fail( trans("El codigo de verificacion es incorrecto"), 402);

        $user->activation_telephone='';
        $user->active_telephone= true;
        $user->save();

        return jsend_success($user, 202, 'Su teléfono ha sido verificado.');

    }

/*
    $string = str_random(15);

    // Available alpha caracters
$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

// generate a pin based on 2 * 7 digits + a random character
$pin = mt_rand(1000000, 9999999)
. mt_rand(1000000, 9999999)
. $characters[rand(0, strlen($characters) - 1)];

// shuffle the result
$string = str_shuffle($pin)
*/
}
