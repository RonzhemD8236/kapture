<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileSetupController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {return view('home'); })->name('home');
Route::get('/about', function () { return view('about'); })->name('about');



// Auth Routes
Auth::routes(['verify' => true, 'logout' => false]);

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');

Route::get('/home', function () {
    if (Auth::check()) {
        $customer = \DB::table('customer')->where('id', Auth::id())->first();
        if (!$customer) {
            return redirect('/customer/profile/setup');
        }
        return redirect('/customer/home');
    }
    return redirect('/login');
})->middleware('auth');

// Public Routes
Route::get('/shop', [ItemController::class, 'getItems'])->name('getItems');
Route::get('/add-to-cart/{id}', [ItemController::class, 'addToCart'])->name('addToCart');
Route::get('/shopping-cart', [ItemController::class, 'getCart'])->name('getCart');
Route::get('/reduce/{id}', [ItemController::class, 'getReduceByOne'])->name('reduceByOne');
Route::get('/remove/{id}', [ItemController::class, 'getRemoveItem'])->name('removeItem');

Route::prefix('customer')->middleware(['auth'])->group(function () {
    Route::get('/profile/setup', [ProfileSetupController::class, 'show'])->name('customer.profile.setup');
    Route::post('/profile/setup', [ProfileSetupController::class, 'store'])->name('customer.profile.setup.store');
    });

Route::get('/product/{id}', [ItemController::class, 'show'])->name('product.show');

// Customer Routes
Route::prefix('customer')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/place', [CheckoutController::class, 'store'])->name('checkout.place');
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
    Route::put('/review/{review_id}', [ReviewController::class, 'update'])->name('review.update');

    Route::get('/profile', [CustomerController::class, 'create'])->name('customer.profile');
    Route::post('/profile', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('customer.home');
    Route::get('/profile/edit', [ProfileSetupController::class, 'edit'])->name('customer.profile.edit');
    Route::put('/profile/edit', [ProfileSetupController::class, 'update'])->name('customer.profile.update');
});

    Route::get('/contact', function () { return view('contact');})->name('contact');


// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::delete('/reviews/{review_id}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');

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