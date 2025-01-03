<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory as BaseFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class Factory extends BaseFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    /**
     * Generates a number of any length using Faker's generator
     */
    public function randomNumber(int $digits): string
    {
        $number = '';
        for($i = 0; $i < $digits; $i++) $number .= fake()->randomDigit();
        return $number;
    }
}