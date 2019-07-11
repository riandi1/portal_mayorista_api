<?php

use Illuminate\Database\Seeder;
use App\Models\Store\Category;
use App\Models\Store\Product;
class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Category::all()->each(function (Category $category) {
            if ($category->id>11) {
                $category_name = $category->name;
                for ($i = 0; $i<100; $i++) {
                    $product = Product::updateOrCreate([
                        "name" => "Producto".$i,
                        "description" => $category_name,
                        "price" => 10250000,
                        "seen" => $i,
                        "category_id" => $category->id,
                        "category_father_id" => $category->id - 11,
                        "image10" => "",
                        "user_id" => 4
                    ]);
                  }
            }


        });

    }
}
