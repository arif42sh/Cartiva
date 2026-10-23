<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupBuyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/hot-deals', [HomeController::class, 'hotDeals'])->name('hot-deals.index');
Route::get('/flash-sales', [HomeController::class, 'flashSales'])->name('flash-sales.index');
Route::get('/group-pools', [HomeController::class, 'groupPools'])->name('group-pools.index');
Route::get('/categories', [HomeController::class, 'categoriesIndex'])->name('categories.index');
Route::get('/category/{category:slug}', [HomeController::class, 'category'])->name('category.show');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/group-buy/{session:group_code}', [GroupBuyController::class, 'show'])->name('group-buy.show');
Route::get('/shop/{seller}', [HomeController::class, 'shop'])->name('shop.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Authenticated Customer & Buying Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/group-buy/start/{product}', [GroupBuyController::class, 'start'])->name('group-buy.start');
    Route::post('/group-buy/join/{session}', [GroupBuyController::class, 'join'])->name('group-buy.join');
    Route::post('/group-buy/dismiss/{session}', [GroupBuyController::class, 'dismiss'])->name('group-buy.dismiss');
    
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('checkout.process');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::post('/product/{product}/reviews', [ProductController::class, 'storeReview'])->name('products.reviews.store');
});

/*
|--------------------------------------------------------------------------
| Seller Portal Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    // 1. Dashboard & Analytics
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    Route::get('/analytics', [SellerController::class, 'analytics'])->name('analytics');
    Route::get('/storefront', [SellerController::class, 'storefront'])->name('storefront');

    // 2. Product Management (CRUD, Image upload, Pricing tiers, Stock)
    Route::get('/products', [SellerController::class, 'products'])->name('products');
    Route::get('/products/create', [SellerController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [SellerController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [SellerController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [SellerController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [SellerController::class, 'destroyProduct'])->name('products.destroy');
    Route::patch('/products/{product}/toggle-status', [SellerController::class, 'toggleProductStatus'])->name('products.toggle-status');
    Route::patch('/products/{product}/quick-stock', [SellerController::class, 'quickStockUpdate'])->name('products.quick-stock');

    // 3. Group Buy Campaigns & Active Groups Monitoring (x, xi)
    Route::get('/groups', [SellerController::class, 'groups'])->name('groups');
    Route::post('/groups', [SellerController::class, 'storeGroup'])->name('groups.store');
    Route::get('/groups/{session}', [SellerController::class, 'showGroup'])->name('groups.show');
    Route::post('/groups/{session}/relaunch', [SellerController::class, 'relaunchGroup'])->name('groups.relaunch');

    // 4. Order Management & Fulfillment (xii, xiii)
    Route::get('/orders', [SellerController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [SellerController::class, 'showOrder'])->name('orders.show');
    Route::patch('/orders/{order}/status', [SellerController::class, 'updateOrderStatus'])->name('orders.update-status');

    // 5. Merchant Store Profile & Settings (i)
    Route::get('/profile', [SellerController::class, 'profile'])->name('profile');
    Route::put('/profile', [SellerController::class, 'updateProfile'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Admin Portal Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/groups', [AdminController::class, 'groups'])->name('groups');
    Route::post('/check-expirations', [AdminController::class, 'triggerExpirationCheck'])->name('trigger-check');
});
