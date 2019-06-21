<?php

namespace App\Models\System\Parametrics;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\System\User;

class DocumentType extends Model
{
    public $relationships = ['country'];
    protected $fillable = ['country_id', 'name', 'description', 'type_person'];
    protected $dates = ['deleted_at'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function users(): HasMany{
        return $this->hasMany(User::class,'document_type_id','id');
    }

}
