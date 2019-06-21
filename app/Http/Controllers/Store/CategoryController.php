<?php

namespace App\Http\Controllers;


use App\Models\Store\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct(Category::class);
    }

}
