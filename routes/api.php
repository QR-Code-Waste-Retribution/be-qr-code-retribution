<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;
use App\Utils\DokuGenerateToken;
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

Route::post('login', [AuthController::class, 'login']);


// User
Route::put('user/change/{id}/password', [UserController::class, 'changePassword']);
Route::put('user/edit/{id}/profile', [UserController::class, 'editProfile']);
Route::post('user/add', [AuthController::class, 'register']);

// Invoice
Route::post('people/{uuid}/invoice', [InvoiceController::class, 'getInvoiceOfUserByUUID']);
Route::resource('invoice', InvoiceController::class);

// Transaction
Route::get('/transaction/pemungut/{id}', [TransactionController::class, 'historyTransactionPemungut'])->name('transaction.history.pemungut');
Route::resource('transaction', TransactionController::class);



// Category
Route::resource('category', CategoriesController::class);




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
