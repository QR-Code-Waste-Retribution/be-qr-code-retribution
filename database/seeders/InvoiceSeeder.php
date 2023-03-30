<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::with('category')->get();
        foreach ($users as $user) {
            foreach ($user->category as $category) {
                $invoice = Invoice::create([
                    'category_id' => $category->id,
                    'price' => $category->price,
                    'user_id' => $user->id,
<<<<<<< HEAD
                    'type' => 0,
                ]);
                $this->command->info(json_encode($invoice, JSON_PRETTY_PRINT));
=======
                    'uuid_user' => $user->uuid,
                    'status' => 0,
                ]);
                // $this->command->info(json_encode($invoice, JSON_PRETTY_PRINT));
>>>>>>> 01bfd2ac2cf14e38b1783403b04502601050fd36
            }   
        }
    }
}

// $price = 0;
// foreach ($user->category as $category) {
//     $price += $category->price;
// }   
// $this->command->info(json_encode(number_format($price, 2), JSON_PRETTY_PRINT)); 