<?php

namespace App\Http\Controllers;

use App\Models\Store\CategoryFeacture;
use App\Models\Store\Favorite;
use App\Models\Store\Product;
use App\Models\Store\ProductFeacture;
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
        $request->merge(['user_id' =>$user->id]);
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
                return jsend_fail('', 402, trans("The feactures do not correspond"));
            $rows++;
        }

        if ($rows!=$rows2)
            return jsend_fail('', 402, trans("The feactures do not correspond"));

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
            }
        }
        return $response;

    }


    public function update(Request $request, $id)
    {
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
                return jsend_fail('', 402, trans("The feactures do not correspond"));
            $rows++;
        }

        if ($rows!=$rows2)
            return jsend_fail('', 402, trans("The feactures do not correspond"));

        $response = parent::update($request, $id);
        $data = $response->getData(true);
        if ($data["status"] == "success") {
            foreach ($request->product_feactures as $key => $value) {
                $feacture = ProductFeacture::find($value['id']);
                $feacture -> value = $value['value'];
                $feacture->save();
            }
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
        return jsend_success($product, 202, trans("messages.models.update", ["model" => $this->model::basename()]));
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

}
