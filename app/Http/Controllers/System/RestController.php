<?php

namespace App\Http\Controllers;


use App\Models\Store\Category;
use App\Models\Store\Favorite;
use App\Models\Store\Product;
use App\Models\System\User;
use App\Notifications\SignupActivate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use function Sodium\add;

class RestController extends BaseController
{

    public function storeUser(Request $request)
    {

        $user = User::where([['email', $request->email]])->first();
        if ($user != null) {
            return jsend_fail('El correo electrónico ya ha sido registrado.');
        }

        $user = User::updateOrCreate([
            "email" => $request->email,
            "first_surname" => $request->first_surname,
            "first_name" => $request->first_name,
            "password" => bcrypt($request->password),
            'activation_token' => str_random(60),
        ]);
        if (!$user->hasRole('seller'))
            $user->assignRole('seller');
        if (!$user->hasDirectPermission('CATEGORY_INDEX'))
            $user->givePermissionTo('CATEGORY_INDEX');
        if (!$user->hasDirectPermission('CATEGORYFEACTURE_INDEX'))
            $user->givePermissionTo('CATEGORYFEACTURE_INDEX');

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
        return redirect(env('APP_FRONT_URL', 'http://104.140.246.214') . '/login');
    }

    public function listCategory()
    {
        //$categories = Category::with('subCategories')->find(1);
        $categories = Category::with('subCategories')->where('category_id', null)->get();
        return $categories;
    }


    public function listProduct(Request $request)
    {
        //Filter
        $categoryFather = $request->categoryFather;
        $categoryFather = ($categoryFather) ? ['products.category_father_id', '=', $categoryFather] : ['products.id', '!=', 0];
        $category = $request->category;
        $category = ($category) ? ['products.category_id', '=', $category] : ['products.id', '!=', 0];
        $location = $request->location;
        $location = ($location) ? ['users.location', 'ILIKE', '%' . $location . '%'] : ['products.id', '!=', 0];
        $minimum = $request->minimum;
        $minimum = ($minimum) ? ['products.price', '>=', $minimum] : ['products.id', '!=', 0];
        $maximum = $request->maximum;
        $maximum = ($maximum) ? ['products.price', '<=', $maximum] : ['products.id', '!=', 0];
        $published = $request->published;
        $date = date('Y-m-d', strtotime($published . " days"));
        $published = ($published) ? ['products.created_at', '>=', $date] : ['products.id', '!=', 0];
        //advanced
        $advanced = $request->advanced;
        $user_id = $request->user_id;
        $user_id = ($user_id) ? $user_id : 0;

        $advancedArray = explode(" ", $advanced);
        //$query = Product::table('node');


        $products = Product
            ::leftJoin('favorites', function ($join) use ($user_id) {
                $join->on('products.id', '=', 'favorites.product_id')
                    ->where('favorites.user_id', '=', 1);
            })
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('users', 'products.user_id', '=', 'users.id')
            ->select('products.*')
            ->where([
                ['products.deleted_at', null],
                ['products.active', true],
                $categoryFather,
                $category,
                $location,
                $minimum,
                $maximum,
                $published,
                $categoryFather,
            ]);


        for ($i = 0; $i < count($advancedArray); $i++) {
            $products->Where(function ($query) use ($advancedArray, $i) {
                $query->where('products.name', 'ILIKE', '%' . $advancedArray[$i] . '%')
                    ->orWhere('products.description', 'ILIKE', '%' . $advancedArray[$i] . '%')
                    ->orWhere('categories.name', 'ILIKE', '%' . $advancedArray[$i] . '%');
            });
        }

        $products->orderBy('web_positioning', 'DESC')
            ->orderBy('product_id', 'ASC')
            ->orderBy('products.id', 'DESC');

        // ->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
        // ->get();
        $products = $products->paginate(28);;

        $priceMax = Product::max('price');
        /*$filter = [
            'categoryFather' => $request->categoryFather,
            'category' => $request->category,
            'location' => $request->location,
            'minimum' => $request->minimum,
            'maximum' => $request->maximum,
            'published' => $request->published,
            'advanced' => $request->advanced,
            'user_id' => $request->user_id,
        ];*/


        $result = ['data' => $products, 'priceMax' => $priceMax];
        return jsend_success($result, 202);
    }


    public function product($id,$user)
    {
        $product = Product::with('productFeactures', 'user')->find($id);
        $favorite = Favorite::where([
            ['user_id', $user],
            ['product_id', $product->id]
        ])->first();

        $product->seen = $product->seen + 1;
        $product->save();
        $validFavorite = ($favorite) ? true : false;
        $result = ['data' => $product, 'favorite' => $validFavorite];
        return $result;
    }


    public function listProductTop()
    {
        $products = Product::orderBy('seen', 'DESC')->take(4)->get();
        return jsend_success($products, 202);
    }

    public function listProductTop2()
    {
        $products = Product::orderBy('seen', 'DESC')->skip(4)->take(9)->get(); //get next 10 rows
        return jsend_success($products, 202);
    }

    public function listProductTop3()
    {
        $products = Product::orderBy('seen', 'DESC')->skip(13)->take(9)->get(); //get next 10 rows
        return jsend_success($products, 202);
    }

}