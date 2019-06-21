<?php

namespace App\Models\Cms;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    public $relationships = ['vars'];
    protected $fillable = ['id', 'name', 'title', 'description'];

    public function vars(): HasMany{
        return $this->hasMany(PageVar::class, 'page_id', 'id');
    }
}
