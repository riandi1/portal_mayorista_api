<?php

namespace App\Models\System;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    public $relationships = [];
    protected $fillable = ['name', 'value', 'promotion'];
    protected $dates = ['deleted_at'];


    protected $rules = [
        'value' => 'required|unique:plans'
    ];


}
