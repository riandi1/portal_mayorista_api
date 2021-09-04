<?php

namespace App\Models\Store;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class CategoryFeacture extends Model
{
    protected $fillable = ['key', 'type', 'required','category_id'];
    protected $relationships = ['category'];
    protected $rules = [
        'key' => 'required'
    ];


    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }
}
