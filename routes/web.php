<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileSetupController;
use App\Http\Controllers\AdminProfileController;
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
    Route::get('/profile/setup', [ProfileSetupController::class, 'show'])->name('customer.profile.setup');
    Route::post('/profile/setup', [ProfileSetupController::class, 'store'])->name('customer.profile.setup.store');
    Route::get('/profile/edit', [ProfileSetupController::class, 'edit'])->name('customer.profile.edit');
    Route::put('/profile/edit', [ProfileSetupController::class, 'update'])->name('customer.profile.update');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/profile', [AdminProfileController::class, 'show'])->name('admin.profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('/dashboard/product-chart', [DashboardController::class, 'productChartData'])->name('dashboard.productChartData');
    Route::get('/users', [DashboardController::class, 'getUsers'])->name('admin.users');
    Route::get('/customers', [DashboardController::class, 'getCustomers'])->name('admin.customers');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::patch('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::resource('customers', CustomerController::class);
    Route::get('/orders', [DashboardController::class, 'getOrders'])->name('admin.orders');
    Route::get('/order/{id}', [OrderController::class, 'processOrder'])->name('admin.orderDetails');
    Route::post('/order/{id}', [OrderController::class, 'orderUpdate'])->name('admin.orderUpdate');
    Route::post('/items-import', [ItemController::class, 'import'])->name('item.import');
    Route::get('/items/trash', [ItemController::class, 'trash'])->name('items.trash');
    Route::patch('/items/{id}/restore', [ItemController::class, 'restore'])->name('items.restore');
    
    Route::delete('/items/{id}/force-delete', [ItemController::class, 'forceDelete'])->name('items.forceDelete');
    Route::resource('items', ItemController::class);
});