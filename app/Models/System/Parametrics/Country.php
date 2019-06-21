<?php

namespace App\Models\System\Parametrics;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Store\Plan;
use App\Models\System\User;

class Country extends Model
{
    public $relationships = [];
    protected $fillable = ['id', 'name', 'iso2', 'iso3', 'telephone_prefix', 'latitude', 'longitude','coint','coint_sign','coint_value'];
    protected $dates = ['deleted_at'];

    public function states(): HasMany
    {
        return $this->hasMany(State::class, 'country_id', 'id');
    }

    public function documentTypes(): HasMany
    {
        return $this->hasMany(DocumentType::class, 'country_id', 'id');
    }

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class, 'country_id', 'id');
    }


    public function users(): HasMany{
        return $this->hasMany(User::class,'country_id','id');
    }

}
