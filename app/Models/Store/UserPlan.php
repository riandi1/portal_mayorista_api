<?php

namespace App\Models\Store;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPlan extends Model
{
    public $relationships = ['user','plan'];
    protected $fillable = ['plan_id', 'user_id'];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

}
