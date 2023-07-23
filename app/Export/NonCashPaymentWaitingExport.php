<?php
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class NonCashPaymentWaitingExport implements FromView{
    protected $transaction;
    protected $penilaian;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function view(): View
    {
        return view('pages.transaction.noncash-waiting.data_table_format', [
            'transactions' => $transactions,
        ]);
    }
}