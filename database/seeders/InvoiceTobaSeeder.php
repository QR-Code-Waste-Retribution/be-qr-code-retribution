<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Seeder;

class InvoiceTobaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('district_id', )
            ->where('role_id', 1)
            ->with(['category'])
            ->get();

        foreach ($users as $user) {
            foreach ($user->category as $category) {
                Invoice::create([
                    'category_id' => $category->pivot->category_id,
                    'price' => $category->price,
                    'user_id' => $user->id,
                    'uuid_user' => $user->uuid,
                    'masyarakat_transaction_id' => null,
                    'status' => 0,
                ]);
            }
        }
    }
}
