<?php

namespace App\Models\System;

use App\Models\Model;

class CustomField extends Model
{
    public static $prefix = 'CUSTOM_FIELD';
    protected $fillable = [
        'id', 'model', 'name', 'type', 'required', 'allow'
    ];

    protected $casts = [
        'allow' => 'array'
    ];
}
