<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            // Generates a fake full name
            'name' => fake()->name(),
            // Generates a fake last name
            'last_name' => fake()->lastName,
            // Generates a unique and safe email address
            'email' => fake()->unique()->safeEmail(),
            // Sets the email verification timestamp to the current time
            'email_verified_at' => now(),
            // Hashes the password 'password' if not already hashed
            'password' => static::$password ??= Hash::make('password'),
            // Generates a random string for the remember token
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        // Sets the 'email_verified_at' attribute to null, indicating the email is unverified
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
