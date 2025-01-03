<?php

namespace Database\Seeders\Receipts;

use App\Models\Receipts\ReceiptType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReceiptTypeSeeder extends Seeder
{
    /**
     * Receipts types data (Table 3 of SRI's technical sheet)
     */
    private array $receipt_types = [
        ['FACTURA', '01'],
        // ['LIQUIDACIÓN DE COMPRA DE BIENES Y PRESTACIÓN DE SERVICIOS', '03'],
        // ['NOTA DE CRÉDITO', '04'],
        // ['NOTA DE DÉBITO', '05'],
        // ['GUÍA DE REMISIÓN', '06'],
        // ['COMPROBANTE DE RETENCIÓN', '07']
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->receipt_types as $receipt_type){
            ReceiptType::create([
                'name' => $receipt_type[0],
                'code' => $receipt_type[1]
            ]);
        }
    }
}
