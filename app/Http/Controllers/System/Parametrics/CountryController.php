<?php

namespace App\Http\Controllers;

use App\Models\System\Parametrics\Country;


class CountryController extends Controller
{

    public function __construct()
    {
        parent::__construct(Country::class);
    }

}
