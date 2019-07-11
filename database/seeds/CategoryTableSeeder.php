<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                "name" => "Accesorio automóviles",
                "description" => "Accesorio automóviles",

            ],
            [
                "name" => "Carros y motos",
                "description" => "Carros y motos",

            ],
            [
                "name" => "Inmuebles",
                "description" => "Inmuebles",

            ],            [
                "name" => "Electrodomésticos",
                "description" => "Electrodomésticos",

            ],
            [
                "name" => "Hogar y decoración",
                "description" => "Hogar y decoración",

            ],
            [
                "name" => "Artículos de oficina",
                "description" => "Artículos de oficina",

            ],            [
                "name" => "Belleza y cuidado personal",
                "description" => "Belleza y cuidado personal",

            ],
            [
                "name" => "Mascotas",
                "description" => "Mascotas",

            ],
            [
                "name" => "Servicios",
                "description" => "Servicios",

            ],            [
                "name" => "Tecnología",
                "description" => "Tecnología",

            ],
            [
                "name" => "Cónsolas y videojuegos",
                "description" => "Cónsolas y videojuegos",

            ],

        ];

        foreach ($datas as $data) {
            \App\Models\Store\Category::create($data);
        }



        $datas2 = [
            [
                "name" => "Accesorio automóviles",
                "description" => "Accesorio automóviles",
                "category_id" => 1,

            ],
            [
                "name" => "Carros y motos",
                "description" => "Carros y motos",
                "category_id" => 2,

            ],
            [
                "name" => "Inmuebles",
                "description" => "Inmuebles",
                "category_id" => 3,

            ],            [
                "name" => "Electrodomésticos",
                "description" => "Electrodomésticos",
                "category_id" => 4,

            ],
            [
                "name" => "Hogar y decoración",
                "description" => "Hogar y decoración",
                "category_id" => 5,

            ],
            [
                "name" => "Artículos de oficina",
                "description" => "Artículos de oficina",
                "category_id" => 6,

            ],            [
                "name" => "Belleza y cuidado personal",
                "description" => "Belleza y cuidado personal",
                "category_id" => 7,

            ],
            [
                "name" => "Mascotas",
                "description" => "Mascotas",
                "category_id" => 8,

            ],
            [
                "name" => "Servicios",
                "description" => "Servicios",
                "category_id" => 9,

            ],            [
                "name" => "Tecnología",
                "description" => "Tecnología",
                "category_id" => 10,

            ],
            [
                "name" => "Cónsolas y videojuegos",
                "description" => "Cónsolas y videojuegos",
                "category_id" => 11,

            ],

        ];

        foreach ($datas2 as $data) {
            \App\Models\Store\Category::create($data);
        }

    }
}
