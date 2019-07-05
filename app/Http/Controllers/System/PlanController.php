<?php

namespace App\Http\Controllers;

use App\Models\System\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function __construct()
    {
        parent::__construct(Plan::class);
    }

}
