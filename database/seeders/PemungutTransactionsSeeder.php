<?php

namespace Database\Seeders;

use App\Models\PemungutTransaction;
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

        $user = User::all()->where('role_id', 2);

        foreach ($user as $item) {
            for ($i = 0; $i < 3; $i++) {
                $startOfMonth = Carbon::now()->startOfMonth();
                $startOfRange = $startOfMonth->copy()->subMonths($i);
                $endOfRange = $startOfMonth->copy()->subMonths($i - 1)->subDay();
                $randomTimestamp = Carbon::createFromTimestamp(rand($startOfRange->timestamp, $endOfRange->timestamp));
                $randomPrice = number_format(rand(10000, 99999), 2);
                $randomPriceWithZeros = substr($randomPrice, 0, 2) . '000';
                PemungutTransaction::create([
                    'status' => $i == 2 ? 1 : 0,
                    'pemungut_id' => $item->id,
                    'total' => (int)$randomPriceWithZeros,
                    'date' => $randomTimestamp,
                ]);
            }
        }
    }
}
