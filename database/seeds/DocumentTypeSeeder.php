<?php

use Illuminate\Database\Seeder;
use App\Models\System\Parametrics\DocumentType;

class DocumentTypeSeeder extends Seeder
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
                'country_id' => 45,
                'name' => 'CC',
                'description' => 'Cédula de Ciudadanía',
                'type_person' => 'Natural'
            ],
            [
                'country_id' => 45,
                'name' => 'CE',
                'description' => 'Cédula de Extranjero',
                'type_person' => 'Natural'
            ],
            [
                'country_id' => 45,
                'name' => 'NIT',
                'description' => 'Número de Identificación Tributaria',
                'type_person' => 'Jurídica'
            ]
        ];
        foreach ($datas as $data) {
            DocumentType::create($data);
        }
    }
}
