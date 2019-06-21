<?php

namespace App\Models\Cms;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageVar extends Model
{
    public $relationships = ['page'];
    protected $fillable = ['id', 'name', 'value', 'type', 'is_array'];

    public function page(): BelongsTo {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }
}
