<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;
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

Route::post('/socket', function (Request $request) {
    $data = $request['data'];
    $uuid = $request['uuid'];
    
    event(new \App\Events\QREvent($data, $uuid));
    return null;
});

Route::post('login', [AuthController::class, 'login']);


// User
Route::put('user/change/{id}/password', [UserController::class, 'changePassword']);
Route::put('user/edit/{id}/profile', [UserController::class, 'editProfile']);
Route::get('user/all/{sub_district_id}', [UserController::class, 'getAllUserBySubDistrict']);

// Auth
Route::post('user/add', [AuthController::class, 'register']);

// Invoice
Route::get('/invoice/users/all/{sub_district_id}', [InvoiceController::class, 'getAllUserForInvoicePaidAndUnpaid']);
Route::get('/invoice/total/compensated/', [InvoiceController::class, 'getTotalAmountUnpaidAndPaidInvoice']);
Route::post('people/{uuid}/invoice', [InvoiceController::class, 'getInvoiceOfUserByUUID']);
Route::resource('invoice', InvoiceController::class);

// Transaction
Route::get('/transaction/pemungut/{id}', [TransactionController::class, 'historyTransactionPemungut'])->name('transaction.history.pemungut');
Route::get('/transaction/masyarakat/{id}', [TransactionController::class, 'getHistoryTransactionMasyarakat'])->name('transaction.history.masyarakat');
Route::post('/transaction/store/non-cash', [TransactionController::class, 'storeNonCash'])->name('transaction.store.non-cash');
Route::post('/transaction/store/additional', [TransactionController::class, 'storeAddtionalRetribution'])->name('transaction.store.additional');
Route::put('/transaction/update/non-cash/status/{transaction_id}', [TransactionController::class, 'updateNonCashStatusAfterPayment'])->name('transaction.store.non-cash');
Route::resource('transaction', TransactionController::class);

// Category
Route::resource('category', CategoriesController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
