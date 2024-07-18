<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total' => fake()->randomFloat(2, 10, 1000),
            'shipping_address' => fake()->address,
            'mobile_phone'=> fake()->phoneNumber,
            'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'delivered']),
            // Assigns a random user ID from existing users
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
