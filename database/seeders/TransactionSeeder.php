<?php

namespace Database\Seeders;

use App\Models\User;
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
        $user = User::all();

        foreach ($user as $item) {
            
        }
        
        $this->command->info(json_encode($user, JSON_PRETTY_PRINT));

    }
}
