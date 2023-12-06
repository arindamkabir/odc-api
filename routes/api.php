<?php

use App\Http\Controllers\Ecom\ProductController;
use App\Http\Controllers\Ecom\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/categories', [ShopController::class, 'categories'])->name('shop.categories');
Route::get('/colors-sizes', [ShopController::class, 'colorsSizes'])->name('shop.colors-sizes');
