<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\HomepageController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\KatalogController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderController as FrontendOrderController;
use App\Http\Controllers\Backend\OrderController as BackendOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomepageController::class, 'index'])->name('homepage');

Route::get('/welcome', function () {
    return view('frontend.welcome');
});

Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/produk', [ProductController::class, 'index'])->name('frontend.products.index');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('frontend.products.show');

// Favorites
Route::post('/favorite/toggle/{productId}', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorite.toggle');
Route::get('/favorite/check/{productId}', [\App\Http\Controllers\FavoriteController::class, 'check'])->name('favorite.check');
Route::get('/favorite/count', [\App\Http\Controllers\FavoriteController::class, 'count'])->name('favorite.count');
Route::get('/favorit', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');

Route::get('/kategori/multiple', [CategoryController::class, 'multiple'])->name('category.multiple');

Route::get('/kategori/{category}', [CategoryController::class, 'show'])->name('category');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

Route::get('/dashboard', function () {
    return view('backend.dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Frontend Orders (Pesanan Saya) - Available for all authenticated users
    Route::get('/pesanan-saya', [FrontendOrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan-saya/{id}', [FrontendOrderController::class, 'show'])->name('orders.show');
});

// Backend routes - Only accessible by admin and super admin
Route::middleware(['auth', 'admin'])->group(function () {
    // Category Management
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);

    // Product Management
    Route::resource('products', \App\Http\Controllers\ProductController::class);

    // Backend Orders (Pesanan Masuk)
    Route::get('/admin/orders', [BackendOrderController::class, 'index'])->name('backend.orders.index');
    Route::get('/admin/orders/{id}', [BackendOrderController::class, 'show'])->name('backend.orders.show');
    Route::post('/admin/orders/{id}/update-status', [BackendOrderController::class, 'updateStatus'])->name('backend.orders.update-status');
});

require __DIR__.'/auth.php';
