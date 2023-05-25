<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $number = 1;
        $this->command->info("STATUS", JSON_PRETTY_PRINT);
        $users = User::with('category')->get();
        // $break = false;
        foreach ($users as $user) {
            // if ($break) break;
            foreach ($user->category as $category) {
                $status = fake()->randomElement([0, 1]);
                if ($status) {
                    $transaction = $this->createDummyTransaction($number, $status, $user);
                    $number++;
                    Invoice::create([
                        'category_id' => $category->id,
                        'price' => $category->price,
                        'user_id' => $user->id,
                        'uuid_user' => $user->uuid,
                        'masyarakat_transaction_id' => $transaction->id,
                        'status' => $status,
                    ]);
                    // $break = true;
                    // break;
                } else {
                    Invoice::create([
                        'category_id' => $category->id,
                        'price' => $category->price,
                        'user_id' => $user->id,
                        'uuid_user' => $user->uuid,
                        'masyarakat_transaction_id' => null,
                        'status' => $status,
                    ]);
                }
            }
        }
    }

    public function createDummyTransaction($number, $status, $user)
    {
        $randomInt = fake()->randomElement([0, 1]);
        $paymentMethod = ['CASH', 'NONCASH'];
        $reference_number = 'REF-' . date('Ymd') . '-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4) . '-' . substr(str_shuffle((string)time() . '1234567890'), 0, 7);
        $transaction_number = 'TRAN-' . date('Ymd') . '-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5) . '-' . substr(str_shuffle((string)time() . '1234567890'), 0, 7);
        $pemungut = User::inRandomOrder()->where('role_id', 2)->where('district_id', $user->district_id)->first();

        $transaction = Transaction::create([
            'price' => fake()->randomElement([10000, 20000, 30000, 40000, 50000]),
            'status' => $status,
            'date' =>  Carbon::now()->subMonths(rand(0, 4))->format('Y-m-d'),
            'type' => $paymentMethod[$randomInt],
            'invoice_number' => "INV-" . (string)(time() + $number),
            'reference_number' => $reference_number,
            'transaction_number' => $transaction_number,
            'user_id' => $user->id,
            'pemungut_id' => $randomInt ? null : $pemungut->id,
            'sub_district_id' => $pemungut->sub_district_id,
            'category_id' => Category::inRandomOrder()->where('district_id', $user->district_id)->first()->id,
        ]);

        return $transaction;
    }
}

// $price = 0;
// foreach ($user->category as $category) {
//     $price += $category->price;
// }   
// $this->command->info(json_encode(number_format($price, 2), JSON_PRETTY_PRINT)); 