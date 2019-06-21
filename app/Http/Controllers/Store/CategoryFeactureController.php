<?php

namespace App\Http\Controllers;

use App\Models\Store\CategoryFeacture;

class CategoryFeactureController extends Controller
{
    public function __construct()
    {
        parent::__construct(CategoryFeacture::class);
    }
}
