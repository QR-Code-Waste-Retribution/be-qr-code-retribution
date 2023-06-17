<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\PemungutTransaction;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

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
        echo phpinfo();
        die;
        // Get Already Deposit and Not Yet Deposited Monthly Categories
        $deposit = $this->pemungut_transaction->getDepositMonthlyDataByDistrictId();

        // Get CASH and NON CASH transctions total price
        $income = $this->transactions->sumTransactionByType();

        $users = $this->users->getAllCountOfUsersRole();
        $graph = $this->pemungut_transaction->getIncomeData();

        // Retrive Already Deposit and Not Yet Deposited Additional Categories
        $income_tambahan = $this->pemungut_transaction->getDepositAdditionalDataByDistrictId();

        $invoice_monthly = $this->invoice->totalAmountUnpaidAndPaidInvoiceMonthly();

        // return [
        //     'deposit' => $deposit,
        //     'income' => $income,
        //     'users' => $users,
        //     'graph' => $graph,
        //     'income_tambahan' => $income_tambahan,
        //     'invoice_monthly' => $invoice_monthly,
        // ];

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
