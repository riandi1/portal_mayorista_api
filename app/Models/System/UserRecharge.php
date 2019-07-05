<?php

namespace App\Models\System;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRecharge extends Model
{
    public $relationships = ['user'];
    protected $fillable = ['name', 'value', 'promotion','user_id'];
    protected $dates = ['deleted_at'];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

}
