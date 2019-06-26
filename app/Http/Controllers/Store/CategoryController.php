<?php

namespace App\Http\Controllers;


use App\Models\Store\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct(Category::class);
    }
}
