<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Retrieve a random user ID
        $userId = User::inRandomOrder()->first()->id;


        return [

            // Generates a new theme ID using the Theme model factory
            'theme_id' => function () {
                return \App\Models\Theme::factory()->create()->id;
            },

            // Generates a fake
            'name' => fake()->company,
            'history' => fake()->paragraph,
            'production_methods' => fake()->paragraph,
            'specialties' => fake()->word,
            'zip_code' => fake()->postcode,

            // Generates a fake description with 3 paragraphs
            'description' => fake()->paragraphs(3, true),

            // Assigns the previously retrieved random user ID
            'user_id' => $userId,

        ];
    }
}
