<?php

namespace App\Models\Store;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    public $relationships = ['country','userPlans'];
    protected $fillable = ['country_id', 'name', 'value', 'promotion'];
    protected $dates = ['deleted_at'];


    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }


    public  function userPlans(): HasMany{
        return $this->hasMany(UserPlan::class, 'plan_id', 'id');
    }
}
