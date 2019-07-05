<?php

use App\Models\System\Util;
use Illuminate\Database\Seeder;

class UtilTableSeeder extends Seeder
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
                "key" => "PRECIO_PUBLICACION",
                "value" => 2500,
                "alias" => "Precio de publicacion"

            ],
            [
                "key" => "PRECIO_POSICION",
                "value" => 1000,
                "alias" => "Precio para posicionamiento de producto"

            ]

        ];

        foreach ($datas as $data) {
            Util::create($data);
        }

    }
}
