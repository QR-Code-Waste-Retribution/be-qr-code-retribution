<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $number = 1;
        $randomInt = fake()->randomElement([0, 1]);
        $paymentMethod = ['CASH', 'NONCASH'];
        $reference_number = 'REF-' . date('Ymd') . '-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4) . '-' . substr(str_shuffle((string)time() . '1234567890'), 0, 7);
        $transaction_number = 'TRAN-' . date('Ymd') . '-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5) . '-' . substr(str_shuffle((string)time() . '1234567890'), 0, 7);
        $masyarakat = User::inRandomOrder()->first();
        $pemungut = User::inRandomOrder()->where('role_id', 2)->where('district_id', $masyarakat->district_id)->first();

        $transaction = Transaction::create([
            'price' => fake()->randomElement([10000, 20000, 30000, 40000, 50000]),
            'status' => fake()->randomElement([0, 1]),
            'date' =>  Carbon::now()->subMonths(rand(0, 4))->format('Y-m-d'),
            'type' => $paymentMethod[$randomInt],
            'invoice_number' => "INV-" . (string)(time() + $number++),
            'reference_number' => $reference_number,
            'transaction_number' => $transaction_number,
            'user_id' => $masyarakat,
            'pemungut_id' => $randomInt ? null : $pemungut,
            'sub_district_id' => $pemungut->sub_district_id,
            'category_id' => Category::inRandomOrder()->where('district_id', $masyarakat->district_id)->first(),
        ]);
    }
}
