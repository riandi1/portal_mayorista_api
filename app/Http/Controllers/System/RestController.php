<?php

namespace App\Http\Controllers;


use App\Models\Store\Category;
use App\Models\Store\Product;
use App\Models\System\Parametrics\Country;
use App\Models\System\Parametrics\State;
use App\Models\System\Parametrics\City;
use App\Models\System\Parametrics\DocumentType;
use App\Models\System\User;
use App\Notifications\SignupActivate;
use Illuminate\Http\Request;

class RestController
{
    public function getAllCountry()
    {
        $countries = Country::all();
        return $countries;
    }

    public function getAllState()
    {
        $states = State::all();
        return $states;
    }

    public function getAllCity()
    {
        $cities = City::all();
        return $cities;
    }

    public function getAllDocumentType()
    {
        $documentType = DocumentType::all();
        return $documentType;
    }

    public function storeUser(Request $request)
    {

        $user = User::where([['email', $request->email]])->first();
        if ($user!=null){
            return jsend_fail('El correo electrónico ya ha sido registrado.');
        }

        $user = User::where([['document_type_id', $request->document_type_id], ['document_number', $request->document_number]])->first();
        if ($user!=null){
            return jsend_fail('El numero de documento ya ha sido registrado.');
        }

        $user = User::updateOrCreate([
            "name" => $this->creaUserName($request['first_name'], $request['first_surname']),
            "email" =>  $request->email,
            "first_surname" =>  $request->first_surname,
            "first_name" =>  $request->first_name,
            "password" => bcrypt($request->password),
            'document_number' => $request->document_number,
            'document_type_id' => $request->document_type_id,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' =>$request->city_id,
            'activation_token'  => str_random(60),
        ]);

        if (!$user->hasRole('master'))
            $user->assignRole('master');


        $user->notify(new SignupActivate($user));

        return jsend_success($user, 202, 'User has been created.');
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
        return $user;
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


    private function creaUserName($name, $surName)
    {
        $user = $name . '.' . $surName;
        $existe = true;
        $i = 0;
        $aux = $user;
        while ($existe) {
            $cantidad = user::where('name', '=', $aux)->first();
            if (!empty($cantidad)) {
                $i++;
                $aux = $user . $i;
            } else {
                $existe = false;
                break;
            }
        }
        return $aux;
    }


}
