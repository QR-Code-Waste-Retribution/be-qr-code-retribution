<?php

namespace App\Http\Controllers\Transaction;

use App\Export\PaymentExport;
use App\Http\Controllers\Controller;
use App\Models\PemungutTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CashPaymentController extends Controller
{

    public $pemungut_transactions;

    public function __construct() {
        $this->pemungut_transactions = new PemungutTransaction();
    }

    public function export()
    {
        return Excel::download(new PaymentExport('CASH'), 'cash.xlsx');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $month = $request->month ?? '';
        $sub_district = $request->sub_district ?? null;

        $pemungut_transactions = $this->pemungut_transactions->getAllTransaction($sub_district, $search);
        // $targetIncome = $this->pemungut_transactions->getIncomeData();

        // return $targetIncome;
        return view('pages.transaction.cash.cash-payment', compact('pemungut_transactions'));
    }

    public function show($id)
    {
        $cash = $this->pemungut_transactions->show($id);
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
