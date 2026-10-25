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
Route::get('/track-order', [OrderController::class, 'trackOrder'])->name('orders.track');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/switch-user/{role}', [AuthController::class, 'switchUser'])->name('switch-user');

Route::middleware('guest')->group(function () {
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

    // i. Customer Management (SRS 4.4.i)
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers.index');
    Route::get('/customers/{user}', [AdminController::class, 'showCustomer'])->name('customers.show');
    Route::post('/customers/{user}/toggle-status', [AdminController::class, 'toggleCustomerStatus'])->name('customers.toggle-status');

    // ii & iii. Seller Management & Approvals (SRS 4.4.ii, iii)
    Route::get('/sellers', [AdminController::class, 'sellers'])->name('sellers.index');
    Route::get('/sellers/{user}', [AdminController::class, 'showSeller'])->name('sellers.show');
    Route::post('/sellers/{user}/approve', [AdminController::class, 'approveSeller'])->name('sellers.approve');
    Route::post('/sellers/{user}/reject', [AdminController::class, 'rejectSeller'])->name('sellers.reject');
    Route::post('/sellers/{user}/toggle-status', [AdminController::class, 'toggleSellerStatus'])->name('sellers.toggle-status');

    // iv. Product Categories (SRS 4.4.iv)
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('categories.destroy');

    // v. Products Catalog Oversight (SRS 4.4.v)
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::post('/products/{product}/toggle-status', [AdminController::class, 'toggleProductStatus'])->name('products.toggle-status');
    Route::post('/products/{product}/toggle-feature', [AdminController::class, 'toggleProductFeature'])->name('products.toggle-feature');
    Route::post('/products/{product}/approve', [AdminController::class, 'approveProduct'])->name('products.approve');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('products.destroy');

    // vi. Monitor Group Sessions (SRS 4.4.vi)
    Route::get('/groups', [AdminController::class, 'groups'])->name('groups');
    Route::post('/groups/{session}/relaunch', [AdminController::class, 'relaunchGroup'])->name('groups.relaunch');
    Route::post('/check-expirations', [AdminController::class, 'triggerExpirationCheck'])->name('trigger-check');

    // vii. Order Management (SRS 4.4.vii)
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');

    // viii. Monitor Payments & Escrow (SRS 4.4.viii)
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
    Route::post('/orders/{order}/release-escrow', [AdminController::class, 'releaseEscrow'])->name('orders.release-escrow');

    // ix. Refund Requests (SRS 4.4.ix)
    Route::get('/refunds', [AdminController::class, 'refunds'])->name('refunds');
    Route::post('/refunds/{refund}/approve', [AdminController::class, 'approveRefund'])->name('refunds.approve');
    Route::post('/refunds/{refund}/reject', [AdminController::class, 'rejectRefund'])->name('refunds.reject');

    // x. Reported Issues & Disputes (SRS 4.4.x)
    Route::get('/issues', [AdminController::class, 'issues'])->name('issues');
    Route::get('/issues/{issue}', [AdminController::class, 'showIssue'])->name('issues.show');
    Route::post('/issues/{issue}/resolve', [AdminController::class, 'resolveIssue'])->name('issues.resolve');

    // xi. Platform Statistics (SRS 4.4.xi)
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');

    // xii. Announcements & Notifications (SRS 4.4.xii)
    Route::get('/announcements', [AdminController::class, 'announcements'])->name('announcements');
    Route::post('/announcements', [AdminController::class, 'storeAnnouncement'])->name('announcements.store');
    Route::post('/announcements/{announcement}/toggle', [AdminController::class, 'toggleAnnouncement'])->name('announcements.toggle');
    Route::delete('/announcements/{announcement}', [AdminController::class, 'deleteAnnouncement'])->name('announcements.destroy');

    // xiii. Overall System Activities & Logs (SRS 4.4.xiii)
    Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('activity-logs');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
});
