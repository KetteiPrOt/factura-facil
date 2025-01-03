<?php

namespace Database\Factories\Persons;

use App\Models\Persons\IdentificationType;
use App\Models\User;
use Database\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persons\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $max_user_id = User::orderBy('id', 'desc')->first()->id;
        $max_identification_type_id = IdentificationType::orderBy('id', 'desc')->first()->id;
        return [
            'identification' => $this->randomNumber(13),
            'social_reason' => fake()->name(),
            'email' => fake()->email(),
            'phone_number' => $this->randomNumber(10),
            'address' => fake()->sentence(),
            'identification_type_id' => fake()->numberBetween(1, $max_identification_type_id),
            'user_id' => fake()->numberBetween(1, $max_user_id),
        ];
    }
}
