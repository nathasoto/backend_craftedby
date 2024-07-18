<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// Rutas de productos fuera de la autenticación
//Route::get('/products', [ProductController::class, 'index']);
//Route::get('/products/{product}', [ProductController::class, 'show']);
//Route::post('/products', [ProductController::class, 'store']);

// Rutas CRUD de productos dentro de la autenticación
//Route::middleware('auth')->group(function () {
//    Route::resource('products', ProductController::class)->except(['index', 'show']);
//});

require __DIR__.'/auth.php';
