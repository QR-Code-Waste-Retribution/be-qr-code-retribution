<?php

namespace App\Export;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class NonCashPaymentWaitingExport implements FromView{
    protected $transaction;

    public function __construct(Collection $transaction)
    {
        $this->transaction = $transaction;
    }

    public function view(): View
    {
        return view('pages.transaction.noncash-waiting.data_table_format', [
            'transactions' => $this->transaction,
        ]);
    }
}