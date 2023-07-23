<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Report\ReportController;

use App\Http\Controllers\Transaction\CashPaymentController;
use App\Http\Controllers\Transaction\NonCashPaymentController;
use App\Http\Controllers\Transaction\NonCashPaymentWaitingController;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\MasyarakatController;
use App\Http\Controllers\User\PemungutController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware(['auth', 'role:petugas_kabupaten'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/pemasukan', [HomeController::class, 'income'])->name('dashboard.income');

    // User Management
    Route::prefix('user')->group(function () {

        // Masyarakat
        Route::get('/masyarakat/all/qrcode', [MasyarakatController::class, 'exportAllQRCodeImage'])->name('masyarakat.qrcode');
        Route::get('/masyarakat/verification', [MasyarakatController::class, 'verificationCreate'])->name('masyarakat.verification');
        Route::get('/masyarakat/verification/{pemungut_id}', [MasyarakatController::class, 'verificationDetail'])->name('masyarakat.verification.detail');
        Route::post('/masyarakat/verification/', [MasyarakatController::class, 'changeStatusVerificationUser'])->name('masyarakat.verification.detail.store');
        Route::post('/masyarakat/status', [MasyarakatController::class, 'changeStatusUser'])->name('masyarakat.status');
        Route::resource('masyarakat', MasyarakatController::class);

        // Pemungut
        Route::resource('pemungut', PemungutController::class);
        Route::post('pemungut/status', [PemungutController::class, 'changeStatusUser'])->name('pemungut.status');
    });

    // User
    Route::resource('user', UserController::class);

    // Categories
    Route::resource('category', CategoryController::class);
    Route::post('/category/status', [CategoryController::class, 'changeStatusCategory']);

    // Cash Payment
    Route::put('transaction-cash/change/status', [CashPaymentController::class, 'changeDepositStatus'])->name('cash.payment.change.status');
    Route::get('transaction-cash/export', [CashPaymentController::class, 'export'])->name('transaction-cash.export');
    Route::get('transaction-cash/status/wait', [CashPaymentController::class, 'indexWait'])->name('transaction-cash.status.index.wait');
    Route::get('transaction-cash/status/confirmed', [CashPaymentController::class, 'indexConfirmed'])->name('transaction-cash.status.index.confirmed');
    Route::get('transaction-cash/status/{status}', [CashPaymentController::class, 'index'])->name('transaction-cash.status.index');
    Route::resource('transaction-cash', CashPaymentController::class)->except(['index']);

    // Non Cash Payment
    Route::get('transaction-noncash/export', [NonCashPaymentController::class, 'export'])->name('transaction-noncash.export');
    Route::get('transaction-noncash/{sub_district_id}', [NonCashPaymentController::class, 'showNonCashTransactionBySubDistrictId'])->name('transaction-noncash.sub_district_id');
    Route::resource('transaction-noncash', NonCashPaymentController::class)->only(['index']);
    Route::resource('transaction-noncash-waiting/{payment_via}/payment', NonCashPaymentWaitingController::class);
    Route::post('transaction-noncash-waiting/{payment_via}/payment/confirmation/selected', [NonCashPaymentWaitingController::class, 'confirmation_selected']);



    // Reports 
    Route::resource('invoice',  InvoiceController::class);

    // Reports 
    Route::resource('reports',  ReportController::class);
});


Route::get('/test', function (Request $request) {
    $response = Http::post('http://localhost:6001/send-message', ['uuid' => '5196fc71-2c14-3bdd-87e7-711dd9bd6e5d', 'name' => 'Zico']);
    $responseJson = json_decode($response->body(), true);
    $httpCode = $response->status();

    return [
        'body' => $responseJson,
        'code' => $httpCode,
    ];
});
