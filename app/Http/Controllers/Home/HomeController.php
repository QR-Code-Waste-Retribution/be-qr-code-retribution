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
        // Get Already Deposit and Not Yet Deposited Monthly Categories
        $deposit = $this->pemungut_transaction->getDepositMonthlyDataByDistrictId();

        // Get CASH and NON CASH transctions total price in transaction
        $income = $this->transactions->sumTransactionByType();
        $income_custom = $this->transactions->sumTransactionByTypeCustom();

        $users = $this->users->getAllCountOfUsersRole();
        $graph = $this->pemungut_transaction->getIncomeData();

        // Retrive Already Deposit and Not Yet Deposited Additional Categories
        $income_tambahan = $this->pemungut_transaction->getDepositAdditionalDataByDistrictId();

        $invoice_monthly = $this->invoice->totalAmountUnpaidAndPaidInvoiceMonthly();

        $total_pemasukan_bulan_ini_top_card = ($income_custom['NONCASH']['verified'] ?? 0) + ($deposit['already_deposited']['total'] ?? 0);
        $total_pemasukan_bulan_ini_non_cash_card = ($income_custom['NONCASH']['verified'] ?? 0) + ($income_custom['NONCASH']['not_verified'] ?? 0);
        $total_pemasukan_bulan_ini_card_3 = ($income_custom['NONCASH']['verified'] ?? 0) + ($deposit['already_deposited']['total'] ?? 0) + ($deposit['not_yet_deposited']['total'] ?? 0) + ($income_tambahan['already_deposited']['total'] ?? 0) + ($income_tambahan['not_yet_deposited']['total'] ?? 0);

        $total_pemasukan_bulan_ini_card_not_yet_deposited = 0;
        $total_pemasukan_bulan_ini_card_not_yet_deposited = $income_tambahan['not_yet_deposited']['total'] + $deposit['not_yet_deposited']['total'] ?? 0;

        $total_pemasukan_bulan_ini_card_already_deposited = 0;
        $total_pemasukan_bulan_ini_addtional_card_already_deposited = $income_tambahan['already_deposited']['total'] ?? 0;
        if (isset($income_tambahan['already_deposited']['total']) && isset($deposit['already_deposited']['total'])) {
            $total_pemasukan_bulan_ini_card_already_deposited = $income_tambahan['already_deposited']['total'] + $deposit['already_deposited']['total'];
        }

        // return [
        //     'income_c' => $income_custom,
        //     'deposit' => $deposit,
        //     'income' => $income,
        //     'users' => $users,
        //     'graph' => $graph,
        //     'income_tambahan' => $income_tambahan,
        //     'invoice_monthly' => $invoice_monthly,
        //     'total_pemasukan_bulan_ini_card_3' => $total_pemasukan_bulan_ini_card_3,
        //     'total_pemasukan_bulan_ini_card_not_yet_deposited' => $total_pemasukan_bulan_ini_card_not_yet_deposited,
        //     'total_pemasukan_bulan_ini_card_already_deposited' => $total_pemasukan_bulan_ini_card_already_deposited,
        // ];

        return view('pages.home', compact(
            'deposit',
            'users',
            'graph',
            'invoice_monthly',
            'income_tambahan',
            'income',
            'income_custom',
            'total_pemasukan_bulan_ini_card_3',
            'total_pemasukan_bulan_ini_top_card',
            'total_pemasukan_bulan_ini_non_cash_card',
            'total_pemasukan_bulan_ini_card_not_yet_deposited',
            'total_pemasukan_bulan_ini_card_already_deposited',
            'total_pemasukan_bulan_ini_addtional_card_already_deposited'
        ));
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
