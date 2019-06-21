<?php

namespace App\Models\Store;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    public $relationships = ['user','product'];
    protected $fillable = ['user_id', 'product_id'];


    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }
}
