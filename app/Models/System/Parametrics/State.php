<?php

namespace App\Models\System\Parametrics;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\System\User;

class State extends Model
{

    public $relationships = ['country'];
    protected $fillable = ['country_id', 'name', 'hasc', 'latitude', 'longitude'];
    protected $dates = ['deleted_at'];


    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'state_id', 'id');
    }

    public function users(): HasMany{
        return $this->hasMany(User::class,'state_id','id');
    }
}
