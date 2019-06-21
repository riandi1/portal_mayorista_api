<?php

namespace App\Http\Controllers;

use App\Models\System\CustomField;

class CustomFieldController extends Controller
{
    public function __construct()
    {
        parent::__construct(CustomField::class);
    }

    public function getFields($resource)
    {
        $result = CustomField::query()->where('model', '=', $resource)->get();
        if (!$result)
            $result = [];
        return jsend_success($result);
    }
}
