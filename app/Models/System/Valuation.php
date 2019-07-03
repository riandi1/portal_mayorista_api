<?php

namespace App\Models\System;


use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Valuation extends Model
{
    public $relationships = ['user','valuationUser'];
    protected $fillable = ['user_id', 'valuation_user_id','valuation','comment'];


    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function valuationUser(): BelongsTo{
        return $this->belongsTo(User::class);
    }

}
