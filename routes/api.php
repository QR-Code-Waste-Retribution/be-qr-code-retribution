<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\DokuController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\PemungutTransactionController;
use App\Http\Controllers\API\SubDistrictController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\User\MasyarakatController;
use App\Http\Controllers\User\PemungutController;
use App\Models\PemungutTransaction;
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
Route::name('api.')->group(function () {

    Route::post('login', [AuthController::class, 'login']);
    
    // User
    
    Route::prefix('user')->group(function () {
        Route::put('/status/change', [MasyarakatController::class, 'changeStatusUser']);
        Route::put('/change/{id}/password', [UserController::class, 'changePassword']);
        Route::put('/edit/{id}/profile', [UserController::class, 'editProfile']);
        Route::get('/all/{pemungut_id}', [UserController::class, 'getAllUserBySubDistrict']);
        Route::post('/add', [AuthController::class, 'register']);
    });
    
    
    // Invoice
    Route::get('/invoice/users/all/{pemungut_id}', [InvoiceController::class, 'getAllUserForInvoicePaidAndUnpaid']);
    Route::get('/invoice/total/compensated/', [InvoiceController::class, 'getTotalAmountUnpaidAndPaidInvoice']);
    Route::post('people/{uuid}/invoice', [InvoiceController::class, 'getInvoiceOfUserByUUID']);
    Route::resource('invoice', InvoiceController::class);
    
    // Transaction
    
    Route::prefix('transaction')->group(function () {
        Route::get('/pemungut/{id}', [TransactionController::class, 'historyTransactionPemungut'])->name('transaction.history.pemungut');
        Route::get('/masyarakat/{id}', [TransactionController::class, 'getHistoryTransactionMasyarakat'])->name('transaction.history.masyarakat');
        Route::post('/store/non-cash', [TransactionController::class, 'storeNonCash'])->name('transaction.store.non-cash');
        Route::post('/store/additional', [TransactionController::class, 'storeAddtionalRetribution'])->name('transaction.store.additional');
        Route::put('/update/non-cash/status/{transaction_id}', [TransactionController::class, 'updateNonCashStatusAfterPayment'])->name('transaction.store.update.non-cash');
    });
    
    Route::resource('transaction', TransactionController::class);
    
    // Pemungut Transaction
    Route::resource('pemungut_transaction', PemungutTransactionController::class);
    
    // SubDistrict
    Route::resource('sub_district', SubDistrictController::class);
    
    // Notification Payment Doku
    Route::post('/payments/notifications', [DokuController::class, 'notifications'])->name('doku.notification');
    
    // Category
    
    Route::resource('category', CategoriesController::class);
    Route::get('/category/additional/{district_id}', [CategoriesController::class, 'getCategoriesAdditional'])->name('category.additional.district');
    
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
});
