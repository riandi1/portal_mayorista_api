<?php

namespace App\Http\Controllers;


use App\Models\Store\Category;
use App\Models\Store\Product;
use App\Models\System\User;
use App\Notifications\SignupActivate;
use Illuminate\Http\Request;

class RestController
{

    public function storeUser(Request $request)
    {

        $user = User::where([['email', $request->email]])->first();
        if ($user!=null){
            return jsend_fail('El correo electrónico ya ha sido registrado.');
        }

        $user = User::updateOrCreate([
            "email" =>  $request->email,
            "first_surname" =>  $request->first_surname,
            "first_name" =>  $request->first_name,
            "password" => bcrypt($request->password),
            'activation_token'  => str_random(60),
        ]);
        if (!$user->hasRole('master'))
            $user->assignRole('master');

        $user->notify(new SignupActivate($user));

        return jsend_success($user, 202, 'El usuario ha sido creado');
    }


    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json(['message' => 'El token de activación es inválido'], 404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->save();
        return redirect('http://104.140.246.214/login');
    }

    public function listCategory(){
        //$categories = Category::with('subCategories')->find(1);
        $categories = Category::with('subCategories')->get();
        return $categories;
    }


    public function listProduct(){
        $products = Product::all();
        return $products;
    }

    public function product($id){
        $product = Product::with('productFeactures')->find($id);
        return $product;
    }

}
