<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Transaction\CashPaymentController;
use App\Http\Controllers\Transaction\NonCashPaymentController;
use App\Http\Controllers\User\MasyarakatController;
use App\Http\Controllers\User\PemungutController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'index']);

// Dashboard
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('/dashboard/pemasukan', [HomeController::class, 'income'])->name('dashboard.income');

// User Management
Route::prefix('user')->group(function () {
    
    // Masyarakat
    Route::resource('masyarakat', MasyarakatController::class);
    
    // Pemungut
    Route::resource('pemungut', PemungutController::class);
});
Route::resource('user', UserController::class);
Route::resource('category', CategoryController::class);
Route::resource('transaction-cash', CashPaymentController::class);
Route::resource('transaction-noncash', NonCashPaymentController::class);
