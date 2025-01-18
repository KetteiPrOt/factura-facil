<?php

namespace Database\Seeders\Products;

use App\Models\Products\VatRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VatRateSeeder extends Seeder
{
    /**
     * VAT rates data (Table 17 of SRI's technical sheet)
     */
    private array $vat_rates = [
        ['0', 0, '0%'],
        ['4', 15, '15%'],
        ['5', 5, '5%'],
        ['6', 0, 'No objeto de IVA'],
        ['7', 0, 'Exento de IVA']
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->vat_rates as $vat_rate){
            VatRate::create([
                'code' => $vat_rate[0],
                'percentaje' => $vat_rate[1],
                'name' => $vat_rate[2],
            ]);
        }
    }
}
