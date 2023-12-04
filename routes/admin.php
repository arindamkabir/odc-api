<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->group(function () {
Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::put('/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
});

Route::prefix('/categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::post('/', [CategoryController::class, 'store'])->name('store');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
});

Route::prefix('/sizes')->name('sizes.')->group(function () {
    Route::get('/', [SizeController::class, 'index'])->name('index');
    Route::post('/', [SizeController::class, 'store'])->name('store');
    Route::put('/{id}', [SizeController::class, 'update'])->name('update');
    Route::delete('/{id}', [SizeController::class, 'destroy'])->name('destroy');
});

Route::prefix('/colors')->name('colors.')->group(function () {
    Route::get('/', [ColorController::class, 'index'])->name('index');
    Route::post('/', [ColorController::class, 'store'])->name('store');
    Route::put('/{id}', [ColorController::class, 'update'])->name('update');
    Route::delete('/{id}', [ColorController::class, 'destroy'])->name('destroy');
});

Route::prefix('/customers')->name('customers.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::post('/', [CustomerController::class, 'store'])->name('store');
    Route::put('/{id}', [CustomerController::class, 'update'])->name('update');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('destroy');
});

Route::prefix('/orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::post('/', [OrderController::class, 'store'])->name('store');
    Route::get('/{id}', [OrderController::class, 'show'])->name('show');
    Route::put('/{id}', [OrderController::class, 'update'])->name('update');
    Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');
});
// });
