<?php

namespace App\Models\Store;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFeacture extends Model
{
    public $relationships = ['product'];
    protected $fillable = ['product_id','key','value'];

    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }
}
