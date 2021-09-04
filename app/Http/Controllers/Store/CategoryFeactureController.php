<?php

namespace App\Http\Controllers;

use App\Models\Store\CategoryFeacture;
use Illuminate\Http\Request;

class CategoryFeactureController extends Controller
{
    public function __construct()
    {
        parent::__construct(CategoryFeacture::class);
    }

}
