<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Color;
use App\Models\Size;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => fake()->numberBetween(1, 10),
            'unit_price' => fake()->randomFloat(2, 10, 100),
            'color_id' => Color::inRandomOrder()->value('id'),
            'size_id' => Size::inRandomOrder()->value('id'),
            'product_id' => Product::inRandomOrder()->first(),
            'order_id' => Order::inRandomOrder()->first()
        ];
    }
}
