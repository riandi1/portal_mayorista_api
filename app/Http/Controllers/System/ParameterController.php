<?php

namespace App\Http\Controllers;

use App\Models\System\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    public function __construct()
    {
        parent::__construct(Parameter::class);
    }

    public function store(Request $request)
    {
        $request->merge([
            'name' => $request->get('code')
        ]);
        return parent::store($request);
    }
}
