<?php

namespace App\Http\Controllers;


use App\Models\Store\Category;
use App\Models\Store\Product;
use App\Models\System\User;
use App\Notifications\SignupActivate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return jsend_success($user, 202, 'El usuario ha sido creado, ¡Hemos enviado por correo electrónico el enlace para confirmar su contraseña!');
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
        return redirect(env('APP_FRONT_URL', 'http://104.140.246.214').'/login');
    }

    public function listCategory(){
        //$categories = Category::with('subCategories')->find(1);
        $categories = Category::with('subCategories')->get();
        return $categories;
    }


    public function listProduct(){
            // $products = Product::orderBy('web_positioning', 'DESC')->get();
            $products = Product
               /* ::leftJoin('favorites', 'products.id', '=', 'favorites.product_id')
                ->where('favorites.user_id', 6)*/
                //::join('users', 'user_id', '=', 'users.id')
                ::leftJoin('favorites', function ($join) {
                     $join->on('products.id', '=', 'favorites.product_id')
                  ->where('favorites.user_id', '=', 6   );
                 })
                ->select('products.*')
                ->orderBy('web_positioning', 'DESC')
                ->orderBy('product_id', 'ASC')
                ->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
                ->get();

              //  $products = json_encode($products, true);
            return $products;
    }

    public function product($id){
        $product = Product::with('productFeactures','user')->find($id);
        return $product;
    }

}
