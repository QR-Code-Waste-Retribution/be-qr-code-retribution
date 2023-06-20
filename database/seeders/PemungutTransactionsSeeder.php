<?php

namespace Database\Seeders;

use App\Models\PemungutTransaction;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PemungutTransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $masyarakat_transaction = Transaction::whereNotNull('pemungut_id')
            ->where('type', 'CASH')
            ->get();

        $this->processTransactions($masyarakat_transaction);
    }

    function processTransactions($transactions, $index = 0, $i = 1)
    {
        if ($index >= count($transactions)) {
            return; // Base case: stop recursion when all transactions have been processed
        }

        $item = $transactions[$index];

        if ($item->status) {
            if ($i > 2) {
                $i = 2;
            }

            PemungutTransaction::create([
                'status' => fake()->randomElement([0, 1]),
                'pemungut_id' => $item->pemungut_id,
                'date' => date('F Y', strtotime(now())),
            ]);

            $i++;
        }

        $this->processTransactions($transactions, $index + 1, $i); // Recursive call
    }
}
