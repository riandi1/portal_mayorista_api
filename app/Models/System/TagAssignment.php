<?php

namespace App\Models\System;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TagAssignment extends Model
{

    public static $prefix = 'TAG_ASSIGNMENT';
    public $relationships = ['tag'];
    protected $fillable = ['id', 'target_type', 'tag_id', 'target_id'];
    protected $appends = ['record'];

    /**
     * @return BelongsTo
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    public function target(): MorphTo
    {
        return $this->morphTo();
    }
}
