<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeOfService;

class TypeOfServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'service_name' => 'Cuci dan Gosok',
                'price'        => 5000,
                'description'  => 'Layanan cuci dan gosok pakaian per kg',
            ],
            [
                'service_name' => 'Hanya Cuci',
                'price'        => 4500,
                'description'  => 'Layanan cuci pakaian saja per kg',
            ],
            [
                'service_name' => 'Hanya Gosok',
                'price'        => 5000,
                'description'  => 'Layanan gosok pakaian saja per kg',
            ],
            [
                'service_name' => 'Laundry Besar',
                'price'        => 7000,
                'description'  => 'Layanan laundry untuk item besar (selimut, sprei, dll) per kg',
            ],
        ];

        foreach ($services as $service) {
            TypeOfService::create($service);
        }
    }
}
