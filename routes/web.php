<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthenticatedSessionController::class, 'create']);

// Admin routes
Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // Add more admin routes here
});

// User routes
Route::middleware(['auth'])->prefix('user')->group(function () {
    
    Route::get('/dashboard', [UserController::class,'index'])->name('user.dashboard');

    Route::get('/products', [UserController::class,'getProducts'])->name('user.products');

    Route::post('add-to-cart',[UserController::class,'addToCart'])->name('cart.add');
    
    Route::get('/orders', [UserController::class,'getOrders'])->name('user.orders');
});

require __DIR__.'/auth.php';
