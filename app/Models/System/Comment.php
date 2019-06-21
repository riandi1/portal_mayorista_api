<?php

namespace App\Models\System;

use App\Models\Model;
use App\Models\Store\Product;

class Comment extends Model
{
    public $relationships = ['user','product'];
    protected $fillable = ['id', 'user_id', 'target_type', 'target_id', 'message'];
    protected $dates = ['created_at', 'updated_at'];
    protected $rules = [
        'user_id' => 'required',
        'target_id' => 'required',
        'message' => 'required'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function target()
    {
        return $this->morphTo();
    }

}
