<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_order_can_be_stored_to_the_database(): void
    {
            // Create a sample user to exist in the database
            $user = User::factory()->create();

            // Act as the created user to simulate authentication
            $this->actingAs($user);

            // Create example category  for product
            Category::factory()->create();

            // Create example colors for the product
            Color::factory()->count(3)->create()->pluck('id')->toArray();

            // Create example sizes for the product
            Size::factory()->count(2)->create()->pluck('id')->toArray();

        // Create a sample product to exist in the database
            $product = Product::factory()->create();

            // Get a specific color and size for the product
            $color = $product->colors()->first();
            $size = $product->sizes()->first();

            // Test data
            $data = [
                "total" => 20.0,
                "shipping_address" => "123 Main St",
                "mobile_phone" => "1234567890",
                "status" => "pending",
                "products" => [
                    [
                        "id" => $product->id,
                        "quantity" => 2,
                        "unit_price" => 10.0,
                        "color_id" => $color->id,
                        "size_id" => $size->id,
                    ]
                ]
            ];

            // Make the request to create the order
            $response = $this->postJson('/api/create_order', $data);

            // Verify that the order was created successfully
            $response->assertStatus(201);

            // Verify that the order is correctly stored in the database
            $this->assertDatabaseHas('orders', [
                'total' => $data['total'],
                'shipping_address' => $data['shipping_address'],
                'mobile_phone' => $data['mobile_phone'],
                'status' => $data['status'],
                'user_id' => $user->id,
            ]);


        }

}
