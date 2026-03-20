<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AnalyticsController;

Route::resource('products', ProductController::class);
Route::post('products/{product}/images', [ProductController::class, 'uploadImages'])->name('products.images.upload');
Route::delete('products/{product}/images/{index}', [ProductController::class, 'deleteImage'])->name('products.images.delete');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products management
    Route::resource('products', ProductController::class);
    
    // Orders management
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    
    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
});