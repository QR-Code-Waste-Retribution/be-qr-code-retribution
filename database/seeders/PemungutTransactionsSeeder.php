<?php

namespace Database\Seeders;

use App\Models\PemungutTransaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            PemungutTransaction::create([
                'status' => random_int(0, 1),
                'pemungut_id' => $item->id,
                'total' => 200000,
            ]);
        }
        foreach ($user as $item) {
            PemungutTransaction::create([
                'status' => random_int(0, 1),
                'pemungut_id' => $item->id,
                'total' => 200000,
            ]);
        }
        foreach ($user as $item) {
            PemungutTransaction::create([
                'status' => random_int(0, 1),
                'pemungut_id' => $item->id,
                'total' => 200000,
            ]);
        }
    }
}
