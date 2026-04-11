<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;

// halaman
Route::get('/', [PageController::class, 'home']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/contact', [PageController::class, 'contact']);
Route::get('/cart', function () {
    return view('pages.cart');
});

// produk & order
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);

Route::post('/cart/add/{id}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');

Route::post('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');