<?php

namespace Database\Seeders\Persons;

use App\Models\Persons\IdentificationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdentificationTypeSeeder extends Seeder
{
    /**
     * Identification Types (Table 6 of SRI's technical sheet)
     */
    private array $identification_types = [
        ['04', 'RUC'],
        ['05', 'CÉDULA'],
        ['06', 'PASAPORTE'],
        ['07', 'VENTA A CONSUMIDOR FINAL'],
        ['08', 'IDENTIFICACIÓN DEL EXTERIOR'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->identification_types as $identification_type){
            IdentificationType::create([
                'code' => $identification_type[0],
                'name' => $identification_type[1]
            ]);
        }
    }
}
