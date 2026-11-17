<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

Route::get('/', [StoreController::class, 'index'])->name('home');
Route::get('/games/{product:slug}', [StoreController::class, 'show'])->name('games.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/checkout/{denomination}', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/payment-proof', [OrderController::class, 'uploadProof'])->name('orders.proof');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateStatus'])->name('orders.status');
    Route::resource('/categories', AdminController::class)->only(['index','store','update','destroy']);
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::post('/denominations', [AdminController::class, 'storeDenomination'])->name('denominations.store');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
});
