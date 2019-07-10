<?php

namespace App\Http\Controllers;

use App\Models\Store\Category;
use App\Models\Store\CategoryFeacture;
use App\Models\Store\Favorite;
use App\Models\Store\Product;
use App\Models\Store\ProductFeacture;
use App\Models\Store\Reported;
use App\Models\System\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct(Product::class);
    }


    public function store(Request $request)
    {
        $user = Auth::user();
       /* $util = Util::where('key', 'PRECIO_PUBLICACION')->first();
        $result =  $util->value - $user->balance;
        if ($result > 0)
            return jsend_error(trans("Su sueldo no es suficiente, recargue: ".$result), 402);*/


        if ($user->telephone==null or $user->image==null or $user->latitude==null or $user->longitude==null)
            return jsend_error(trans("Complete su perfil se requiere telefono, foto y ubicación"), 402);

        $i=0;
        $feactures="[";
        foreach ($request->request as $key => $value){
             if ($i>0){
                 $feactures .= '{"key":"'.$key.'","value":"'.$value.'"},';
                 $request->request->remove($key);
             }
            if ($key=="image10")  $i++;
        }

        $feactures = substr($feactures, 0, -1);
        $feactures .=']';
        $request->request->add(['product_feactures' => json_decode($feactures, true)]);

        $request->request->add(['user_id' => $user->id]);
        //$request->merge(['user_id' =>$user->id]);
        $categoryFeactures = CategoryFeacture::where('category_id', $request->category_id)->get();
        $rows = 0;
        $rows2 = 0;

        foreach ($categoryFeactures as $key => $value) {
            $cont = 0;
            $rows2 = 0;

           foreach ($request->product_feactures as $keyp => $valuep) {
                if ($value->key===$valuep['key'])
                    $cont++;
                $rows2++;
            }
           if ($cont==0)
                return jsend_fail('', 402, trans("Las características no corresponden."));
            $rows++;
        }

        if ($rows!=$rows2)
            return jsend_fail('', 402, trans("Las características no corresponden."));


        $categoryFather = Category::find($request->category_id);
        $request->merge(['category_father_id' => $categoryFather->category_id]);

        $response = parent::store($request);
        $data = $response->getData(true);
        if ($data["status"] == "success") {
            if (is_array($request->product_feactures)) {
                foreach ($request->product_feactures as $key => $value) {
                    ProductFeacture::create([
                        "key" => $value['key'],
                        "value" => $value['value'],
                        "product_id" => $data["data"]["id"]
                    ]);
                }
               // $user->balance = $user->balance - $util->value;
                //$user->save();
            }
        }
        return $response;
    }


    public function update(Request $request, $id)
    {
        $valid=0;
        if ($request->price==null)
            $valid++;


        if ($valid==0) {
            $i = 0;
            $feactures = "[";
            foreach ($request->request as $key => $value) {
                if ($i > 0) {
                    $feactures .= '{"key":"' . $key . '","value":"' . $value . '"},';
                    $request->request->remove($key);
                }
                if ($key == "description") $i++;
            }

            $feactures = substr($feactures, 0, -1);
            $feactures .= ']';
            $request->request->add(['product_feactures' => json_decode($feactures, true)]);

            $categoryFeactures = CategoryFeacture::where('category_id', $request->category_id)->get();
            $rows = 0;
            $rows2 = 0;

            foreach ($categoryFeactures as $key => $value) {
                $cont = 0;
                $rows2 = 0;

                foreach ($request->product_feactures as $keyp => $valuep) {
                    if ($value->key === $valuep['key'])
                        $cont++;
                    $rows2++;
                }
                if ($cont == 0)
                    return jsend_fail('', 402, trans("Las características no corresponden."));
                $rows++;
            }

            if ($rows != $rows2)
                return jsend_fail('', 402, trans("Las características no corresponden."));

        }

        $response = parent::update($request, $id);
        $data = $response->getData(true);
        if ($data["status"] == "success") {
            if ($valid==0) {
                foreach ($request->product_feactures as $key => $value) {
                    $feacture = ProductFeacture::where([['product_id', $id], ['key', $value['key']]])->first();
                    $feacture->value = $value['value'];
                    $feacture->save();
                }
            }
        }
        return $response;
    }


    public function show(Request $request, $id)
    {

        $response = parent::show($request, $id);
        $data = $response->getData(true);
        if ($data["status"] == "success") {
            $product = Product::find($id);
            $product->seen = $product->seen+1;
            $product->save();
        }
        return $response;
    }


    public function favorite($id){
        $user = Auth::user();
        $product = Product::find($id);
        $favorite = Favorite::where([
           ['product_id', $product->id],
           ['user_id', $user->id]
        ])->first();
        if ($favorite!=null){
            Favorite::find($favorite->id)->forceDelete();
        }else{
            Favorite::create([
            "product_id" => $product->id,
             "user_id" => $user->id
            ]);
        }
        return jsend_success($product, 202, trans("El registro ha sido actualizado"));
    }


    public function listFavorites(){
        $user = Auth::user();
        $products = Product
            ::join('favorites', 'products.id', '=', 'favorites.product_id')
            //->select('products')
            ->where('favorites.user_id', $user->id)
            ->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
            ->get();
        return jsend_success($products, 202);

    }

    public function reported($id){
        $product = Product::find($id);
        if (!$product)
            return jsend_error(trans("El producto no se encuentra"), 404);

        $user = Auth::user();

        $reported = Reported::where([['user_id', $user->id], ['product_id', $id]])->first();
        if ($reported)
            return jsend_fail('', 402, trans("Ya reporto este producto."));

        $reported = new Reported();
        $reported->user_id = $user->id;
        $reported->product_id = $id;
        $reported->save();
        $product->reported = $product->reported+1;
        $product->save();
        return jsend_success($product, 202, 'El producto se ha reportado con exito');


    }


    public function listReported(){
        $products = Product::where([['reported', '>', 0], ['active', true]])->orderBy('reported', 'desc')->get();
        return jsend_success($products, 202);
    }


    public function inactive($id){

        $product = Product::find($id);
        if ($product==null)
            return jsend_error(trans("El producto no se encuentra"), 404);

        $product->active = false;
        $product->delete();
        $product->save();
        return jsend_success($product, 202);

    }


    public function listProductActive(){
        $products = Product::where('active', false)->get();
        return jsend_success($products, 202);
    }

    public function productActive($id){

        $product = Product::find($id);
        if ($product==null)
             return jsend_error(trans("El producto no se encuentra"), 404);

        $product->active = true;
        $product->save();
        return jsend_success($product, 202);

    }


    public function positioning(Request $request, $id){

        $product = Product::find($id);
        if(!$product)
            return jsend_error(trans("El producto no se encuentra"), 404);

        $user = Auth::user();
        $util= Util::where('key', 'PRECIO_POSICION')->first();
        $result = $util->value*$request->positioning - $user->balance;
        if($result > 0)
            return jsend_error(trans("Su sueldo no es suficiente, recargue: ".$result), 402);

        $product->web_positioning = $product->web_positioning + $request->positioning;
        $product->save();
        $user->balance=$user->balance - $util->value*$request->positioning;
        $user->save();
        return jsend_success($product, 202, 'El producto se ha posicionado '.$request->positioning.' niveles arriba');
    }



    public function productSeen(){
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->orderBy('seen', 'DESC')->get();
        return jsend_success($products, 202);
    }





}
