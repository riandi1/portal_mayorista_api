<?php

namespace App\Models\System;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CustomData extends Model
{
    public static $prefix = 'CUSTOM_DATA';
    protected $fillable = [
        'id', 'target_type', 'target_id', 'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function target(): MorphTo
    {
        return $this->morphTo();
    }

}
