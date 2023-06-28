<?php

namespace App\Http\Controllers\Transaction;

use App\Export\PaymentExport;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Maatwebsite\Excel\Facades\Excel;

class NonCashPaymentController extends Controller
{
    public $transaction;


    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $non_cash_payment = $this->transaction->getAllNonCashTransaction();
        $virtual_account = $this->transaction->transactionVirtualAccountByDistrict();
        $qris_total = $this->transaction->transactionQRISByDistrict();

        return view('pages.transaction.noncash.noncash-payment', compact('non_cash_payment'));
    }


    public function export()
    {
        return Excel::download(new PaymentExport('NONCASH'), 'PEMBAYARAN NON TUNAI.xlsx');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id [sub district id]
     * @return \Illuminate\Http\Response
     */
    public function showNonCashTransactionBySubDistrictId($id)
    {
        $non_cash_data = $this->transaction->nonCashTransactionBySubDistrictId($id);
        // return $non_cash_data;
        return view('pages.transaction.noncash.detail', compact('non_cash_data'));
    }
}
