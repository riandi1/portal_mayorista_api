<?php

namespace App\Models\System\Parametrics;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\System\User;

class City extends Model
{
    public $relationships = ['state'];
    protected $fillable = ['state_id', 'name', 'hasc', 'latitude', 'longitude'];
    protected $dates = ['deleted_at'];


    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function users(): HasMany{
        return $this->hasMany(User::class,'city_id','id');
    }

}
