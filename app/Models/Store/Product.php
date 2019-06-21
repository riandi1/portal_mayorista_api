<?php

namespace App\Models\Store;

use App\Models\Model;
use App\Models\System\Comment;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Product extends Model
{

    public $relationships = ['movements','category','productFeactures','favorites'];
    protected $fillable = ['category_id','user_id','id', 'name', 'description','price','seen','quantity','image1', 'image2', 'image3','image4', 'image5', 'image6','image7', 'image8', 'image9', 'image10'];
    protected $rules = [
        'name' => 'required|min:3',
        'price' => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
        'image1' => 'required'
    ];

    public function category(): BelongsTo{
            return $this->belongsTo(Category::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(ProductMovement::class, 'product_id', 'id');
    }

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function favorites():HasMany{
        return $this->hasMany(Favorite::class, 'product_id', 'id');
    }

    public function productFeactures(): HasMany{
        return $this->hasMany(ProductFeacture::class, 'product_id', 'id');
    }

    public function comments():HasMany{
        return $this->hasMany(Comment::class, 'product_id', 'id');
    }
}
