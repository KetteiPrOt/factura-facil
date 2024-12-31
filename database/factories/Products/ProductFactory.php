<?php

namespace Database\Factories\Products;

// use App\Models\Products\IceType;
use App\Models\Products\VatRate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $generator = fake();
        $max_user_id = User::orderBy('id', 'desc')->first()->id;
        // $max_ice_type_id = IceType::orderBy('id', 'desc')->first()->id;
        $max_vat_rate_id = VatRate::orderBy('id', 'desc')->first()->id;
        // $ice_applies = $generator->boolean();
        return [
            'code' => $generator->randomNumber(4, true),
            'name' => ucwords($generator->words(3, true)),
            'price' => $generator->randomFloat(2, 0.01, 999999.99),
            'additional_info' => $generator->boolean() ? $generator->text(255) : null,
            // 'tourism_vat_applies' => $generator->boolean(),
            // 'ice_applies' => $ice_applies,
            'user_id' => $generator->numberBetween(1, $max_user_id),
            // 'ice_type_id' => $ice_applies ? $generator->numberBetween(1, $max_ice_type_id) : null,
            'vat_rate_id' => $generator->numberBetween(1, $max_vat_rate_id)
        ];
    }
}
