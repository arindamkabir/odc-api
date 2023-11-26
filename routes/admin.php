<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->group(function () {


// Route::group(function () {
Route::prefix('/products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
});

Route::prefix('/categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
});
// });
