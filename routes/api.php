<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\SearchController;

Route::prefix('v1')->group(function () {
    // Public API
    Route::get('/products/featured', [ProductController::class, 'featured']);
    Route::get('/products/{product}/related', [ProductController::class, 'related']);
    
    // Protected API
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user/wishlist', [WishlistController::class, 'apiIndex']);
        Route::post('/user/wishlist/toggle/{product}', [WishlistController::class, 'apiToggle']);
    });
});