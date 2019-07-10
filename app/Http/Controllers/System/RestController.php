<?php

namespace App\Http\Controllers;


use App\Models\Store\Category;
use App\Models\Store\Product;
use App\Models\System\User;
use App\Notifications\SignupActivate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class RestController extends BaseController
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


    public function listProduct(Request $request){
        //Filter
        $category = $request->category;
        $category = ($category) ? ['products.category_id', '=', $category] : ['products.id', '!=', 0];
        $location = $request->location;
        $location = ($location) ? ['users.location', 'ILIKE', '%'.$location.'%'] : ['products.id', '!=', 0];
        $minimum = $request->minimum;
        $minimum = ($minimum) ? ['products.price', '>=', $minimum] : ['products.id', '!=', 0];
        $maximum = $request->maximum;
        $maximum = ($maximum) ? ['products.price', '<=', $maximum] : ['products.id', '!=', 0];
        $published = $request->published;
        $date =  date('Y-m-d', strtotime($published." days"));
        $published = ($published) ? ['products.created_at', '>=', $date] : ['products.id', '!=', 0];
        //advanced
        $advanced = $request->advanced;
        $advancedName = ($advanced) ? ['products.name', 'ILIKE', '%'.$advanced.'%'] : ['products.id', '!=', 0];
        $advancedDescription = ($advanced) ? ['products.description', 'ILIKE', '%'.$advanced.'%'] : ['products.id', '!=', 0];
        $advancedCategory = ($advanced) ? ['categories.name', 'ILIKE', '%'.$advanced.'%'] : ['products.id', '!=', 0];

        $user_id = $request->user_id;
        $user_id = ($user_id) ? $user_id : 0;
            $products = Product
                ::leftJoin('favorites', function ($join) use ($user_id) {
                     $join->on('products.id', '=', 'favorites.product_id')
                  ->where('favorites.user_id', '=',   $user_id);
                 })
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('products.*')
                ->where([
                    ['products.deleted_at', null],
                    ['products.active', true],
                    $category,
                    $location,
                    $minimum,
                    $maximum,
                    $published,

                ])
                ->where([
                    $advancedName,
                ])
                ->orWhere([
                    $advancedDescription,
                ])
                ->orWhere([
                    $advancedCategory,
                ])
                ->orderBy('web_positioning', 'DESC')
                ->orderBy('product_id', 'ASC')
                ->orderBy('products.id' , 'DESC')
                ->paginate(30);
               // ->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
               // ->get();

              //  $products = json_encode($products, true);
             return jsend_success($products, 202);
    }

    public function product($id){
        $product = Product::with('productFeactures','user')->find($id);
       $product->seen = $product->seen+1;
        $product->save();
        return $product;
    }


    public function listProductTop(){
        $products =  Product::orderBy('seen', 'DESC')->take(4)->get();
        return jsend_success($products, 202);
    }

}
