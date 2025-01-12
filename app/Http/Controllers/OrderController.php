<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\OrderPriceCalculatorService;

class OrderController extends Controller
{
    private $priceCalculator;

    // Dependency injection in the constructor
    public function __construct(OrderPriceCalculatorService $priceCalculator)
    {
        $this->priceCalculator = $priceCalculator;
    }
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'shipping_address' => 'required|string|max:255', // shipping_address is required, must be a string, and cannot exceed 255 characters
            'mobile_phone' => 'required|string|max:15', // mobile_phone is required, must be a string, and cannot exceed 15 characters
            'status' => 'required|string|max:50', // status is required, must be a string, and cannot exceed 50 characters
            'products' => 'required|array', // products is required and must be an array
            'products.*.id' => 'required|string|exists:products,id', // Each product must have an id that is required, must be a string, and must exist in the products table
            'products.*.quantity' => 'required|integer|min:1', // Each product must have a quantity that is required, must be an integer, and must be at least 1
            'products.*.unit_price' => 'required|numeric|min:0', // Each product must have a unit_price that is required, must be numeric, and must be at least 0
            'products.*.color_id' => 'nullable|string|max:50', // Each product can have a color that is optional, must be a string, and cannot exceed 50 characters
            'products.*.size_id' => 'nullable|string|max:50', // Each product can have a size that is optional, must be a string, and cannot exceed 50 characters
        ]);
        // Get the ID of the authenticated user
        $userId = Auth::check() ? Auth::id() : 1;
        // Prepare the order data
        $orderData = [
            'user_id' => $userId,
            'shipping_address' => $data['shipping_address'],
            'mobile_phone' => $data['mobile_phone'],
            'status' => $data['status'],
        ];
        try {
            // Use a transaction to ensure data integrity
            DB::transaction(function () use ($data,$orderData ) {
                $order = Order::create($orderData);

                // Attach each product to the order with additional details
                foreach ($data['products'] as $productData) {
                    $order->products()->attach($productData['id'], [
                        'quantity' => $productData['quantity'],
                        'unit_price' => $productData['unit_price'],
                        'color_id' => $productData['color_id'],
                        'size_id' => $productData['size_id'],
                    ]);
                }
                // Calculate the total price using the injected service
                $total = $this->priceCalculator->calculateTotal($order);
                $order->update(['total' => $total]);

            });
            // Return a JSON response indicating the order was created successfully with a 201 status code
            return response()->json(['message' => 'Order created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create order', 'error' => $e->getMessage()], 500);
        }
    }

    public function createGuest(Request $request)
    {   // Validate the incoming request data
        $data = $request->validate([
//            'total' => 'required|numeric', // total is required and must be numeric
            'shipping_address' => 'required|string|max:255', // shipping_address is required, must be a string, and cannot exceed 255 characters
            'mobile_phone' => 'required|string|max:15', // mobile_phone is required, must be a string, and cannot exceed 15 characters
            'status' => 'required|string|max:50', // status is required, must be a string, and cannot exceed 50 characters
            'products' => 'required|array', // products is required and must be an array
            'products.*.id' => 'required|string|exists:products,id', // Each product must have an id that is required, must be a string, and must exist in the products table
            'products.*.quantity' => 'required|integer|min:1', // Each product must have a quantity that is required, must be an integer, and must be at least 1
            'products.*.unit_price' => 'required|numeric|min:0', // Each product must have a unit_price that is required, must be numeric, and must be at least 0
            'products.*.color_id' => 'nullable|string|max:50', // Each product can have a color that is optional, must be a string, and cannot exceed 50 characters
            'products.*.size_id' => 'nullable|string|max:50', // Each product can have a size that is optional, must be a string, and cannot exceed 50 characters
        ]);


        // 1 guest
        $userId = 1 ;

        // Prepare the order data
        $orderData = [
            'user_id' => $userId,
            'shipping_address' => $data['shipping_address'],
            'mobile_phone' => $data['mobile_phone'],
            'status' => $data['status'],
        ];

        try {
            // Use a transaction to ensure data integrity
            DB::transaction(function () use ($data,$orderData ) {
                $order = Order::create($orderData);

                // Attach each product to the order with additional details
                foreach ($data['products'] as $productData) {
                    $order->products()->attach($productData['id'], [
                        'quantity' => $productData['quantity'],
                        'unit_price' => $productData['unit_price'],
                        'color_id' => $productData['color_id'],
                        'size_id' => $productData['size_id'],
                    ]);
                }
                $orderPriceCalculator = new OrderPriceCalculatorService();
                $total = $orderPriceCalculator->calculateTotal($order);

                $order->update(['total' => $total]);
            });
            // Return a JSON response indicating the order was created successfully with a 201 status code
            return response()->json(['message' => 'Order created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create order', 'error' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        // Retrieve all orders along with their associated users and products
        $orders = Order::with('user', 'products')->get();
        // Return the orders as a JSON response with a 200 status code
        return response()->json($orders, 200);
    }
    public function delete($id)
    {
        // Find the order by its ID
        $order = Order::find($id);

        if (!$order) {
            // Return a JSON response indicating the order was not found with a 404 status code
            return response()->json(['message' => 'Order not found'], 404);
        }
        // Use a transaction to ensure data integrity
        try {
            DB::transaction(function () use ($order) {
                $order->products()->detach(); // Detach relationships with products
                $order->delete(); // Delete the order
            });

            return response()->json(['message' => 'Order deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete order', 'error' => $e->getMessage()], 500);
        }
    }

    public function ordersByUser()
    {
        $userId = Auth::id();
        // Retrieve orders by user ID along with their associated users and products
        $orders = Order::where('user_id', $userId)
            ->with('user', 'products')
            ->get();

        return response()->json($orders, 200);
    }

    public function UserOrder()
    {
        // Get the authenticated user
//        $user = Auth::user();
        $userId = Auth::id();

        // Check if user is authenticated
        if (!$userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Fetch orders for the authenticated user
        $orders = Order::where('user_id', $userId)->with('products')->get();

        // Return the orders as a JSON response
        return response()->json($orders);
    }
}
