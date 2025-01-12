<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Color;
use App\Models\Order;
use App\Models\Product;
use App\Models\Size;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\OrderPriceCalculatorService;

class OrderTest extends TestCase
{
//    use RefreshDatabase;
    use DatabaseTransactions;
    /**
     *
     */
    public function test_order_can_be_stored_to_the_database(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        Category::factory()->create();
        Color::factory()->count(3)->create();
        Size::factory()->count(2)->create();
        $product1 = Product::factory()->create();
        $color1 = $product1->colors()->first();
        $size1 = $product1->sizes()->first();
        $product2 = Product::factory()->create();
        $color2 = $product2->colors()->first();
        $size2 = $product2->sizes()->first();

        $data = [
            "shipping_address" => "123 Main St",
            "mobile_phone" => "1234567890",
            "status" => "pending",
            "products" => [
                [
                    "id" => $product1->id,
                    "quantity" => 2,
                    "unit_price" => 10.0,
                    "color_id" => $color1->id,
                    "size_id" => $size1->id,
                ],
                [
                    "id" => $product2->id,
                    "quantity" => 2,
                    "unit_price" => 15.0,
                    "color_id" => $color2->id,
                    "size_id" => $size2->id,
                ]
            ]
        ];
        $response = $this->postJson('/api/create_order', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('orders', [
            'shipping_address' => $data['shipping_address'],
            'mobile_phone' => $data['mobile_phone'],
            'status' => $data['status'],
            'user_id' => $user->id,
            // Verify that the total is calculated correctly
            'total' => 50,
        ]);

    }

}

//public function test_order_can_be_stored_to_the_database(): void
//{
//    $priceCalculator = app(OrderPriceCalculatorService::class);
//    $user = User::factory()->create();
//    $this->actingAs($user);
//    Category::factory()->create();
//    Color::factory()->count(3)->create();
//    Size::factory()->count(2)->create();
//    $product1 = Product::factory()->create();
//    $color1 = $product1->colors()->first();
//    $size1 = $product1->sizes()->first();
//    $product2 = Product::factory()->create();
//    $color2 = $product2->colors()->first();
//    $size2 = $product2->sizes()->first();
//
//    $data = [
//        "shipping_address" => "123 Main St",
//        "mobile_phone" => "1234567890",
//        "status" => "pending",
//        "products" => [
//            [
//                "id" => $product1->id,
//                "quantity" => 2,
//                "unit_price" => 10.0,
//                "color_id" => $color1->id,
//                "size_id" => $size1->id,
//            ],
//            [
//                "id" => $product2->id,
//                "quantity" => 2,
//                "unit_price" => 15.0,
//                "color_id" => $color2->id,
//                "size_id" => $size2->id,
//            ]
//        ]
//    ];
//
////        $order = Order::create([
////            'shipping_address' => $data['shipping_address'],
////            'mobile_phone' => $data['mobile_phone'],
////            'status' => $data['status'],
////            'user_id' => $user->id,
////        ]);
////
////        foreach ($data['products'] as $productData) {
////            $order->products()->attach($productData['id'], [
////                'quantity' => $productData['quantity'],
////                'unit_price' => $productData['unit_price'],
////                'color_id' => $productData['color_id'],
////                'size_id' => $productData['size_id'],
////            ]);
////        }
//
////        $expectedTotal = $priceCalculator->calculateTotal($order);
//
//    $response = $this->postJson('/api/create_order', $data);
//
//    $response->assertStatus(201);
//
//    $this->assertDatabaseHas('orders', [
//        'shipping_address' => $data['shipping_address'],
//        'mobile_phone' => $data['mobile_phone'],
//        'status' => $data['status'],
//        'user_id' => $user->id,
//        // Verify that the total is calculated correctly
//        'total' => 50,
//    ]);
//
//
//}
//
//}
