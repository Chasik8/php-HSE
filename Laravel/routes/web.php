<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserAdminController;

// Интернет-магазин
Route::get('/', [ShopController::class, 'index'])->name('shop.home');

// Аутентификация
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Каталог и товары (доступно всем для просмотра)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Корзина и заказы (для авторизованных пользователей)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::post('/orders/create', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/my', [OrderController::class, 'myOrders'])->name('orders.my');

    Route::post('/products/{product}/rate', [RatingController::class, 'store'])->name('products.rate');
});

// Администратор
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [ShopController::class, 'adminDashboard'])->name('dashboard');

    Route::resource('categories', CategoryController::class)->except(['show']);

    Route::get('products', [ProductController::class, 'adminIndex'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('users', [UserAdminController::class, 'index'])->name('users.index');
    Route::post('users/{user}/role', [UserAdminController::class, 'updateRole'])->name('users.updateRole');

    Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback.index');
});

// Форма обратной связи
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.form');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

