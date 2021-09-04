<?php

namespace App\Models\System;

use App\Models\Model;

class Tag extends Model
{
    protected $fillable = ['id', 'name', 'color', 'description', 'required_lvl'];
}
