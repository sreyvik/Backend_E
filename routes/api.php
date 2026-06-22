<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ProfileController;

// Public authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public product & category routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/products/search', [ProductController::class, 'search']);

Route::get('/reviews', [ReviewController::class, 'index']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword']);

    // Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::put('/cart/{cartItem}', [CartController::class, 'update']);
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove']);
    Route::post('/cart/clear', [CartController::class, 'clear']);

    // Orders
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::post('/checkout', [OrderController::class, 'checkout']);

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/add', [WishlistController::class, 'add']);
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'remove']);
    Route::get('/wishlist/check', [WishlistController::class, 'check']);

    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
});

// Admin API routes (protected + admin)
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Api\Admin\DashboardController::class, 'index']);

    // Products
    Route::get('/products', [App\Http\Controllers\Api\Admin\ProductController::class, 'index']);
    Route::post('/products', [App\Http\Controllers\Api\Admin\ProductController::class, 'store']);
    Route::get('/products/{product}', [App\Http\Controllers\Api\Admin\ProductController::class, 'show']);
    Route::put('/products/{product}', [App\Http\Controllers\Api\Admin\ProductController::class, 'update']);
    Route::delete('/products/{product}', [App\Http\Controllers\Api\Admin\ProductController::class, 'destroy']);

    // Categories
    Route::get('/categories', [App\Http\Controllers\Api\Admin\CategoryController::class, 'index']);
    Route::post('/categories', [App\Http\Controllers\Api\Admin\CategoryController::class, 'store']);
    Route::get('/categories/{category}', [App\Http\Controllers\Api\Admin\CategoryController::class, 'show']);
    Route::put('/categories/{category}', [App\Http\Controllers\Api\Admin\CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [App\Http\Controllers\Api\Admin\CategoryController::class, 'destroy']);

    // Orders
    Route::get('/orders', [App\Http\Controllers\Api\Admin\OrderController::class, 'index']);
    Route::get('/orders/{order}', [App\Http\Controllers\Api\Admin\OrderController::class, 'show']);
    Route::patch('/orders/{order}/status', [App\Http\Controllers\Api\Admin\OrderController::class, 'updateStatus']);

    // Users
    Route::get('/users', [App\Http\Controllers\Api\Admin\UserController::class, 'index']);
    Route::get('/users/{user}', [App\Http\Controllers\Api\Admin\UserController::class, 'show']);
    Route::delete('/users/{user}', [App\Http\Controllers\Api\Admin\UserController::class, 'destroy']);
});
