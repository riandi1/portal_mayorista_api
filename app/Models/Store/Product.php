<?php

namespace App\Models\Store;

use App\Models\Model;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Product extends Model
{

    public $relationships = ['category','productFeactures','categoryFather'];
    protected $fillable = ['category_father_id','category_id','user_id','id', 'name', 'description','price','seen','negotiable_price','reported','image1', 'image2', 'image3','image4', 'image5', 'image6','image7', 'image8', 'image9', 'image10'];
    protected $rules = [
        'name' => 'required|min:3',
        'price' => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
    ];

    public function categoryFather(): BelongsTo{
            return $this->belongsTo(Category::class);
    }

    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }


    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }


    public function productFeactures(): HasMany{
        return $this->hasMany(ProductFeacture::class, 'product_id', 'id');
    }

}
