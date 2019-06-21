<?php

namespace App\Http\Controllers;

use App\Models\System\Parametrics\State;

class StateController extends Controller
{
    public function __construct()
    {
        parent::__construct(State::class);
    }

}
