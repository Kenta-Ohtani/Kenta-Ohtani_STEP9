<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [ProductController::class, 'index'])->name('product.index');

    Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/products', [ProductController::class, 'store'])->name('product.store');

    Route::get('/products/{product}', [ProductController::class, 'show'])->name('product.show');

    Route::get('/selling-products/{product}', [ProductController::class, 'sellingShow'])
        ->name('product.selling.show');
    Route::get('/selling-products/{product}/edit', [ProductController::class, 'edit'])
        ->name('product.edit');
    Route::put('/selling-products/{product}', [ProductController::class, 'update'])
        ->name('product.update');
    Route::delete('/selling-products/{product}', [ProductController::class, 'destroy'])
        ->name('product.destroy');

    Route::post('/products/{product}/like', [LikeController::class, 'toggle'])
        ->name('like.toggle');

    Route::get('/products/{product}/purchase', [SaleController::class, 'create'])
        ->name('sale.create');
    Route::post('/products/{product}/purchase', [SaleController::class, 'store'])
        ->name('sale.store');

    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage.index');

    Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');

    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
});
