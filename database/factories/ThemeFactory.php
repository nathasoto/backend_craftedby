<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Theme>
 */
class ThemeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Generates a random element representing a name, either 'Dark' or 'Light'
            'name' => fake()->randomElement(['Dark', 'Light']),
            // Generates a random element representing a color, chosen from 'green', 'blue', or 'white'
            'color' => fake()->randomElement(['green', 'blue', 'white']),
            // Generates a random element representing a font, either 'comicSans' or 'arial'
            'font' => fake()->randomElement(['comicSans', 'arial']),
        ];
    }
}
