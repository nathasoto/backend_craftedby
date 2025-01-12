<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating an admin user with a hashed password
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678')// Password is hashed using bcrypt
        ])->assignRole('admin');// Assigning the 'admin' role

        // Creating a client user with a hashed password
        User::create([
            'name' => 'client',
            'email' => 'client@gmail.com',
            'password' => bcrypt('12345678')// Password is hashed using bcrypt
        ])->assignRole('authClient');// Assigning the 'authClient' role

        // Creating an artisan user with a hashed password
        User::create([
            'name'=>'artisan',
            'email'=>'artisan@gmail.com',
            'password'=>bcrypt('12345678')// Password is hashed using bcrypt
        ])->assignRole('artisan'); // Assigning the 'artisan' role


        // Generates 5 fake users using the User model factory and saves them to the database
        User::factory(5)->create()->each(function($user) {
            $user->assignRole('authClient');
        });
        User::factory(5)->create()->each(function($user) {
            $user->assignRole('artisan');
        });

    }
}
