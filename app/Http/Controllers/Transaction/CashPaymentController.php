<?php

namespace App\Http\Controllers\Transaction;

use App\Export\PaymentExport;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\PemungutTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CashPaymentController extends Controller
{

    public $pemungut_transactions;
    public $invoice;

    public function __construct()
    {
        $this->pemungut_transactions = new PemungutTransaction();
        $this->invoice = new Invoice();
    }

    public function export()
    {
        return Excel::download(new PaymentExport('CASH'), 'PEMBAYARAN TUNAI.xlsx');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $status)
    {
        $search = $request->search ?? '';
        $month = $request->month ?? '';
        $sub_district = $request->sub_district ?? null;
        $invoice_monthly = $this->invoice->totalAmountUnpaidAndPaidInvoiceMonthly();

        $pemungut_transactions = $this->pemungut_transactions->getAllTransaction($sub_district, $search, $status);

        return view('pages.transaction.cash.cash-payment', compact('pemungut_transactions', 'invoice_monthly', 'status'));
    }
    public function indexWait(Request $request)
    {
        $search = $request->search ?? '';
        $month = $request->month ?? '';
        $sub_district = $request->sub_district ?? null;
        $invoice_monthly = $this->invoice->totalAmountUnpaidAndPaidInvoiceMonthly();
        $status = 0;
        
        $pemungut_transactions = $this->pemungut_transactions->getAllTransaction($sub_district, $search, 0);

        return view('pages.transaction.cash.cash-payment', compact('pemungut_transactions', 'invoice_monthly', 'status'));
    }
    public function indexConfirmed(Request $request)
    {
        $search = $request->search ?? '';
        $month = $request->month ?? '';
        $sub_district = $request->sub_district ?? null;
        $invoice_monthly = $this->invoice->totalAmountUnpaidAndPaidInvoiceMonthly();
        $status = 1;

        $pemungut_transactions = $this->pemungut_transactions->getAllTransaction($sub_district, $search, 1);

        return view('pages.transaction.cash.cash-payment', compact('pemungut_transactions', 'invoice_monthly', 'status'));
    }

    public function show($id)
    {
        $cash = $this->pemungut_transactions->show($id);
        // return $cash;
        return view('pages.transaction.cash.detail', compact('cash'));
    }


    public function changeDepositStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pemungut_transaction_id' => 'required',
        ], [
            'required' => 'Input :attribute tidak boleh kosong',
        ]);


        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $id = explode(',', $request->pemungut_transaction_id);
        PemungutTransaction::whereIn('id', $id)->update(['status' => 1]);

        return redirect()->back()->with([
            'type' => 'success',
            'status' => 'Yeyyyy, Anda berhasil mengubah status penyetoran',
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
