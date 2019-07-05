<?php

use App\Models\System\Plan;
use Illuminate\Database\Seeder;

class PlanTableSeeder extends Seeder
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
                    "name" => "Recarga basica",
                    "value" => 50000,

                ],
            [
                "name" => "Recarga media",
                "value" => 25000,

            ],
            [
                "name" => "Recarga superior",
                "value" => 5000,

            ],

            ];

        foreach ($datas as $data) {
            Plan::create($data);
        }


    }
}
