<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (auth()->check() && auth()->user()->role == 'admin') {
        return redirect('/dashboard');
    }

    return redirect('/products');
}); 
// 🌍 PUBLIC
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

// 🔐 SEMUA USER LOGIN
Route::middleware(['auth'])->group(function () {

    // CART
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
    Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // LOGOUT (WAJIB ADA DI SINI)
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});


// 🔒 KHUSUS ADMIN
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class)->except(['index','show']);
    Route::resource('categories', ProductCategoryController::class);

});


// 🔥 TEMPORARY (hapus nanti)
Route::get('/force-logout', function () {
    auth()->logout();
    return redirect('/');
});
Route::delete('/product-image/{id}', function ($id) {
    $img = \App\Models\ProductImage::findOrFail($id);

    if (file_exists(public_path('images/' . $img->image))) {
        unlink(public_path('images/' . $img->image));
    }

    $img->delete();

    return response()->json(['success' => true]);
})->name('product-image.delete');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');
require __DIR__.'/auth.php';