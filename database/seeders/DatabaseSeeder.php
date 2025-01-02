<?php

namespace Database\Seeders;

use App\Models\Products\Product;
use App\Models\User;
use Database\Seeders\Products\IceTypeSeeder;
use Database\Seeders\Products\VatRateSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Defines if false information will be created
     */
    private bool $fake = true;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            VatRateSeeder::class,
            IceTypeSeeder::class
        ]);

        if ($this->fake) {
            Product::factory()->count(100)->create();
        }
    }
}
