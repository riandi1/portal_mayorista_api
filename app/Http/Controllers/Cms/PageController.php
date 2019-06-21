<?php

namespace App\Http\Controllers;

use App\Models\Cms\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        parent::__construct(Page::class);
    }
}
