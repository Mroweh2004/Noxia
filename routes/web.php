<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| NOXIA BAGS MARKET — All Routes
|--------------------------------------------------------------------------
*/

// =============================================================================
// 1. PUBLIC
// =============================================================================

Route::get('/', function () {
    return view('welcome');
})->name('home');

// =============================================================================
// 2. AUTH — Account Login / Register
// =============================================================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
    Route::get('/register', [App\Http\Controllers\Auth\AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\AuthController::class, 'register']);
    Route::get('/signin', [App\Http\Controllers\Auth\AuthController::class, 'showRegisterForm'])->name('signin');
    Route::post('/signin', [App\Http\Controllers\Auth\AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');
});

// =============================================================================
// 3. PRODUCTS — Filter, Search, View (public browsing)
// =============================================================================

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/filter', [App\Http\Controllers\ProductController::class, 'filter'])->name('products.filter');
Route::get('/products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show')->whereNumber('product');

// =============================================================================
// 4. CUSTOMER — Cart, Checkout, Contact, Store Locator (auth required)
// =============================================================================

Route::middleware('auth')->prefix('customer')->name('customer.')->group(function () {
    // Cart
    Route::post('/add/{product}/{cart}', [App\Http\Controllers\Customer\CartController::class, 'add'])
        ->name('cart.add')->whereNumber(['product', 'cart']);
    Route::post('/remove/{product}/{cart}', [App\Http\Controllers\Customer\CartController::class, 'remove'])
        ->name('cart.remove')->whereNumber(['product', 'cart']);
    Route::get('/cart/{cart?}', [App\Http\Controllers\Customer\CartController::class, 'show'])
        ->name('cart.show')->whereNumber('cart');

    // Checkout / Pay
    Route::get('/checkout/{cart}', [App\Http\Controllers\Customer\CheckoutController::class, 'show'])
        ->name('checkout.show')->whereNumber('cart');
    Route::post('/pay/{cart}', [App\Http\Controllers\Customer\CheckoutController::class, 'pay'])
        ->name('pay')->whereNumber('cart');
    Route::get('/checkout/confirmation', [App\Http\Controllers\Customer\CheckoutController::class, 'confirmation'])
        ->name('checkout.confirmation');

    // Contact Support
    Route::get('/contact', [App\Http\Controllers\Customer\ContactController::class, 'show'])->name('contact.show');
    Route::post('/contact', [App\Http\Controllers\Customer\ContactController::class, 'submit'])->name('contact.submit');

    // Store Locator / Live Map
    Route::get('/store', [App\Http\Controllers\Customer\StoreLocatorController::class, 'index'])->name('store.index');
    Route::get('/store/map', [App\Http\Controllers\Customer\StoreLocatorController::class, 'map'])->name('store.map');
});

// =============================================================================
// 5. ADMIN — Products, Roles, Users, Orders (auth + admin required)
// =============================================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Products
    Route::get('/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/sort', [App\Http\Controllers\Admin\ProductController::class, 'sort'])->name('products.sort');
    Route::get('/products/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');

    // Roles
    Route::get('/roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [App\Http\Controllers\Admin\RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [App\Http\Controllers\Admin\RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('roles.destroy');

    // Users
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Orders
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [App\Http\Controllers\Admin\OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [App\Http\Controllers\Admin\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/edit', [App\Http\Controllers\Admin\OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'update'])->name('orders.update');
    Route::patch('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'cancel'])->name('orders.cancel');
});
