<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainBannerController extends Controller
{
    public function ver()
    {
        parent::__construct(Category::class);
    }
}
