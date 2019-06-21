<?php

namespace App\Models\Store;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductMovement extends Model
{
    public static $prefix = 'PRODUCT_MOVEMENT';
    public $relationships = ['product'];

    protected $fillable = ['product_id', 'operation', 'quantity'];
    protected $dates = ['deleted_at'];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
