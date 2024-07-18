<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Calls other seeders to populate the database with initial data
        $this -> call(RoleSeeder::class);

        $this ->call([
            UserSeeder::class,
            AddressSeeder::class,
            CategorySeeder::class,
            ColorSeeder::class,
            SizeSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            OrderProductSeeder::class

        ]);


//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
    }
}
