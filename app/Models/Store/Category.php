<?php

namespace App\Models\Store;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'category_id', 'description', 'image'];
    protected $relationships = ['category','products','categoryFeactures','subCategories'];
    protected $rules = [
        'name' => 'required|min:3',
        'description' => 'required|min:3'
    ];


    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function subCategories(){
        return $this->hasMany(Category::class);
    }

    public function products(): HasMany{
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function categoryFeactures(): HasMany{
        return $this->hasMany(CategoryFeacture::class, 'category_id', 'id');
    }


}
