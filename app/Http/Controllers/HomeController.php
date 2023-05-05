<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PemungutTransaction;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public $transactions;
    public $users;
    public $invoice;
    public $pemungut_transaction;


    public function __construct()
    {
        $this->transactions = new Transaction();
        $this->pemungut_transaction = new PemungutTransaction();
        $this->users = new User();
        $this->invoice = new Invoice();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deposit = $this->pemungut_transaction->getDepositPemungut();
        $income = $this->transactions->sumTransactionByType();
        $users = $this->users->getAllCountOfUsersRole();
        $graph = $this->transactions->getIncomeData();
        $income_tambahan = $this->transactions->getIncomeTambahanDataByDistrictId();
        $invoice_monthly = $this->invoice->totalAmountUnpaidAndPaidInvoiceMonthly();

        return view('pages.home', compact('deposit', 'users', 'graph', 'invoice_monthly', 'income_tambahan', 'income'));
    }

    public function income()
    {
        $transactions = $this->transactions->getAllTransaction();
        return view('pages.dashboard.income', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function show($id)
    {
        //
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
}
