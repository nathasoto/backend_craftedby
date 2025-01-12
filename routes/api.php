<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
//use App\Http\Middleware\ArtisanMiddleware;

use App\Http\Resources\UserCollection;
use App\Models\User;

// Public routes accessible to all users
Route::get('/products', [ProductController::class, 'index']);

// Route to get products by category
Route::get('/products/category/{category}', [ProductController::class, 'getProductsByCategory']);

// Route to search products by keyword
Route::get('products/search/{keyword}', [ProductController::class, 'search']);

Route::get('/products/{product}', [ProductController::class, 'show']);


Route::post('create_order', [OrderController::class, 'store']); // Create a new order

//User
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    // Address-related routes
    Route::get('addresses', [AddressController::class, 'index']); // Get a list of all addresses
    Route::post('addresses', [AddressController::class, 'store']); // Add a new address
    Route::delete('addresses/{id}', [AddressController::class, 'destroy']); // Delete a specific address

    // User-related routes
    Route::post('/logout', [AuthController::class, 'logout']); // Logout the user
    Route::get('/user', [AuthController::class, 'user']); // Get authenticated user's details
    Route::get('/users/{id}', [UserController::class, 'show']); // Get details of a specific user
    Route::get('users/{id}/addresses', [UserController::class, 'getUserAddresses']); // Get addresses of a specific user
    Route::post('get_role', [AuthController::class, 'getRole']); // Get role of the authenticated user

    // User management routes with permission checks
    Route::get('users', [UserController::class, 'index'])->middleware('permission:view.users'); // Get list of users (requires permission)
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Delete a user
    Route::put('/users/{id}', [UserController::class, 'update']); // Update user details

    // Order-related routes

    Route::get('user/orders', [OrderController::class, 'UserOrder'])->middleware('permission:view.order'); // Get orders of the authenticated user (requires permission)
    Route::post('create_order_guest', [OrderController::class, 'createGuest']); // Create an order for a guest user
    Route::get('orders', [OrderController::class, 'index']); // Get a list of all orders
    Route::delete('orders/{id}', [OrderController::class, 'delete']); // Delete a specific order
    Route::get('user/orders', [OrderController::class, 'ordersByUser']); // Get all orders of the authenticated user



    // Product-related routes
    Route::post('products', [ProductController::class, 'store'])->middleware('permission:product.create'); // Add a new product (requires permission)
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy'); // Delete a specific product
    Route::put('/products/{product}', [ProductController::class, 'update']); // Update a specific product

    // Shop-related route
    Route::post('/users/{user_id}/shops', 'ShopController@store'); // Create a shop for a specific user

});


//Route::middleware('auth:sanctum')->group(function () {
//    Route::get('/user', [AuthController::class, 'user']);
//    Route::post('/logout', [AuthController::class, 'logout']);
////    Route::get('/users', [UserController::class, 'index']);
//    Route::get('/users/{id}', [UserController::class, 'show']);
//
//    Route::delete('/users/{id}', [UserController::class, 'destroy']);
//    Route::put('/users/{id}', [UserController::class, 'update']);
//
//    Route::get('users/{id}/addresses', [UserController::class, 'getUserAddresses']);
//    Route::post('get_role', [AuthController::class, 'getRole']);
//
//    Route::post('create_order', [OrderController::class, 'create']);
//
//    Route::get('user/orders', [OrderController::class, 'UserOrder'])->middleware('permission:view.order');
//
//    Route::get('users', [UserController::class, 'index'])->middleware('permission:view.users');
//
//    Route::post('products', [ProductController::class, 'store'])->middleware('permission:create.product');
//    //order
//    Route::post('create_order_guest', [OrderController::class, 'createGuest']);
//    Route::get('orders', [OrderController::class, 'index']);
//    Route::delete('orders/{id}', [OrderController::class, 'delete']);
//    Route::get('user/orders', [OrderController::class, 'ordersByUser']);
//
//   //adresse
//    Route::get('addresses', [AddressController::class, 'index']);
//    Route::post('addresses', [AddressController::class, 'store']);
//    Route::delete('addresses/{id}', [AddressController::class, 'destroy']);
//
//    //product
//
//    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
//    Route::put('/products/{product}', [ProductController::class, 'update']);
//
//    Route::post('/users/{user_id}/shops', 'ShopController@store');
//
//
//});











