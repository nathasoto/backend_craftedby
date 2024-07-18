<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
//            'user_id' => function () {
//                return \App\Models\User::factory()->create()->id;
//            },
            // Generates a fake
            'street' => fake()->streetAddress,
            'city' => fake()->city,
            'postal_code' => fake()->postcode,
            'country' => fake()->country,

            // Assigns a random user ID from existing users
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
