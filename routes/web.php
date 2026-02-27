<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;

// Auth Routes
Auth::routes();

// Public Routes
Route::get('/', [ItemController::class, 'getItems'])->name('getItems');
Route::get('/add-to-cart/{id}', [ItemController::class, 'addToCart'])->name('addToCart');
Route::get('/shopping-cart', [ItemController::class, 'getCart'])->name('getCart');
Route::get('/reduce/{id}', [ItemController::class, 'getReduceByOne'])->name('reduceByOne');
Route::get('/remove/{id}', [ItemController::class, 'getRemoveItem'])->name('removeItem');

// Customer Routes
Route::prefix('customer')->middleware(['auth'])->group(function () {
    Route::get('/checkout', [ItemController::class, 'postCheckout'])->name('checkout');
    Route::get('/logout', [CustomerController::class, 'logout'])->name('user.logout');
    Route::get('/profile', [CustomerController::class, 'create'])->name('customer.profile');
    Route::post('/profile', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/users', [DashboardController::class, 'getUsers'])->name('admin.users');
    Route::get('/customers', [DashboardController::class, 'getCustomers'])->name('admin.customers');
    Route::resource('customers', CustomerController::class); // full CRUD for admin
    Route::get('/orders', [DashboardController::class, 'getOrders'])->name('admin.orders');
    Route::get('/order/{id}', [OrderController::class, 'processOrder'])->name('admin.orderDetails');
    Route::post('/order/{id}', [OrderController::class, 'orderUpdate'])->name('admin.orderUpdate');
    Route::post('/items-import', [ItemController::class, 'import'])->name('item.import');
    Route::resource('items', ItemController::class);
});