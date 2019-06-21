<?php

namespace App\Http\Controllers;

use App\Models\Cms\PageVar;
use Illuminate\Http\Request;

class PageVarController extends Controller
{
    public function __construct()
    {
        parent::__construct(PageVar::class);
    }
}
