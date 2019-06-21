<?php

namespace App\Http\Controllers;

use App\Models\System\Parametrics\City;

class CityController extends Controller
{
    public function __construct()
    {
        parent::__construct(City::class);
    }
}
