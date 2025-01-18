<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Persons\Person;
use App\Models\Products\Product;
use App\Models\User;
use Database\Seeders\Establishments\EstablishmentSeeder;
use Database\Seeders\Persons\IdentificationTypeSeeder;
use Database\Seeders\Products\IceTypeSeeder;
use Database\Seeders\Products\VatRateSeeder;
use Database\Seeders\Receipts\PayMethodSeeder;
use Database\Seeders\Receipts\ReceiptTypeSeeder;
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
        $user_1 = User::factory()->create([
            'name' => 'Test User 1',
            'email' => 'test_1@example.com',
        ]);
        Certificate::create(['user_id' => $user_1->id]);

        $user_2 = User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'test_2@example.com',
        ]);
        Certificate::create(['user_id' => $user_2->id]);

        $this->call([
            VatRateSeeder::class,
            IceTypeSeeder::class,
            IdentificationTypeSeeder::class,
            ReceiptTypeSeeder::class,
            EstablishmentSeeder::class,
            PayMethodSeeder::class
        ]);

        if ($this->fake) {
            Product::factory()->count(100)->create();
            Person::factory()->count(200)->create();
        }
    }
}
