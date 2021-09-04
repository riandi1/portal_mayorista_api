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


        if ($user->telephone==null or $user->image==null)
            return jsend_error(trans("Complete su perfil se requiere telefono y foto "), 402);

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
                if ($key == "negotiable_price") $i++;
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
            if ($valid==0 and $request->product_feactures!=null) {
                foreach ($request->product_feactures as $key => $value) {
                    $feacture = ProductFeacture::where([['product_id', $id], ['key', $value['key']]])->first();
                    $feacture->value = $value['value'];
                    $feacture->save();
                }
            }
        }
        return $response;
    }

}
