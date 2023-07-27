<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Export\NonCashPaymentWaitingExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class NonCashPaymentWaitingController extends Controller
{
    public $transaction;
    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    public function index($payment_via)
    {
        if ($payment_via == "virtual_account") {
            $transactions =  $this->transaction->transactionVirtualAccount();
        }elseif ($payment_via == "qris"){
            $transactions =  $this->transaction->transactionQRIS();
        }else {
            return abort(404);
        }

        return view('pages.transaction.noncash-waiting.index', [
            'transactions' => $transactions,
            'payment_status' => $payment_via
        ]);
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Transaction $payment, $payment_via)
    {
        //
    }

    public function edit(Transaction $payment, $payment_via)
    {
        //
    }

    public function update(Request $request, $payment_via_noncash_waiting, Transaction $payment)
    {
        $transaction = Transaction::find($payment->id);
        $transaction->update([
            'verification_status' => 1
        ]);

        return back()->with('success', 'Transaksi telah berhasil diverifikasi');

    }

    public function destroy(Transaction $payment, $payment_via)
    {
        //
    }

    public function confirmation_selected(Request $request){
        // return $request;
        $data = [
            'input_count' => 'required'
        ];

        $validasi = $request->validate($data);

        $arr_item = explode(",", $request->input_count);

        for($i = 0; $i < count($arr_item); $i++){
           
            $transaction = Transaction::find( $arr_item[$i]);
            $transaction->update([
                'verification_status' => 1
            ]);
        }

        return back()->with('success', 'Seluruh pembayaran telah berhasil dikonfirmasi');
    }

    public function excel_export($payment_via){

        if ($payment_via == "virtual_account") {
            $transactions =  $this->transaction->transactionVirtualAccount();
        }elseif ($payment_via == "qris"){
            $transactions =  $this->transaction->transactionQRIS();
        }else {
            return abort(405);
        }

        // $exportData = new NonCashPaymentWaitingExport($transactions);

        // // Return the export response
        // return $exportData->view();
        return Excel::download(new NonCashPaymentWaitingExport($transactions), 'noncash_payment_waiting.xlsx');
        // Excel::download($exportData, 'transactions.xlsx');
    }
}
