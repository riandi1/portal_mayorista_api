<?php

namespace App\Http\Controllers;


use App\Models\Store\Category;
use App\Models\Store\Product;
use App\Models\System\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

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
            "activation_token" => "xxxxx",
            'active' => true,
        ]);
        if (!$user->hasRole('seller'))
            $user->assignRole('seller');
        if (!$user->hasDirectPermission('CATEGORY_INDEX'))
            $user->givePermissionTo('CATEGORY_INDEX');
        if (!$user->hasDirectPermission('CATEGORYFEACTURE_INDEX'))
            $user->givePermissionTo('CATEGORYFEACTURE_INDEX');

        return jsend_success($user, 202, 'El usuario ha sido creado');
    }

    public function listCategory()
    {
        $categories = Category::with('subCategories')->where('category_id', null)->get();
        return $categories;
    }

    //this function is for looking images in disk public/assets/main_b
    public function mainBanner()
    {
        $file = Storage::disk('mainB')->allFiles();
        return Response::json($file,200);
    }

    public function footerBanner()
    {
        $file = Storage::disk('footerB')->allFiles();
        return Response::json($file,200);
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

        $products = Product
            ::join('categories', 'products.category_id', '=', 'categories.id')
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

        if($advanced){
            for ($i = 0; $i < count($advancedArray); $i++) {
                $products->Where(function ($query) use ($advancedArray, $i) {
                    $query->where('products.name', 'ILIKE', '%' . $advancedArray[$i] . '%')
                    ->orWhere('products.description', 'ILIKE', '%' . $advancedArray[$i] . '%')
                    ->orWhere('categories.name', 'ILIKE', '%' . $advancedArray[$i] . '%');
                });
            }
        }

        $products->orderBy('web_positioning', 'DESC')
            ->orderBy('products.id', 'DESC');

        $products = $products->paginate(28);;
        $priceMax = Product::max('price');

        $result = ['data' => $products, 'priceMax' => $priceMax];
        return jsend_success($result, 202);
    }


    public function product($id)
    {
        $product = Product::with('productFeactures', 'user')->find($id);
        return jsend_success($product, 202);
    }

}