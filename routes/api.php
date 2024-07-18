<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
use App\Http\Middleware\ArtisanMiddleware;

use App\Http\Resources\UserCollection;
use App\Models\User;

// Public routes accessible to all users
Route::get('/products', [ProductController::class, 'index']);

// Route to get products by category
Route::get('/products/category/{category}', [ProductController::class, 'getProductsByCategory']);

// Route to search products by keyword
Route::get('products/search/{keyword}', [ProductController::class, 'search']);

Route::get('/products/{product}', [ProductController::class, 'show']);






//User
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
//    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);

    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::put('/users/{id}', [UserController::class, 'update']);

    Route::get('users/{id}/addresses', [UserController::class, 'getUserAddresses']);
    Route::post('get_role', [AuthController::class, 'getRole']);

    Route::post('create_order', [OrderController::class, 'create']);

    Route::get('user/orders', [OrderController::class, 'UserOrder'])->middleware('permission:view.order');

    Route::get('users', [UserController::class, 'index'])->middleware('permission:view.users');

    Route::post('products', [ProductController::class, 'store'])->middleware('permission:create.product');
    //order
    Route::post('create_order_guest', [OrderController::class, 'createGuest']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::delete('orders/{id}', [OrderController::class, 'delete']);
    Route::get('user/orders', [OrderController::class, 'ordersByUser']);

   //adresse
    Route::get('addresses', [AddressController::class, 'index']);
    Route::post('addresses', [AddressController::class, 'store']);
    Route::delete('addresses/{id}', [AddressController::class, 'destroy']);

    //product

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::put('/products/{product}', [ProductController::class, 'update']);

    Route::post('/users/{user_id}/shops', 'ShopController@store');


});











