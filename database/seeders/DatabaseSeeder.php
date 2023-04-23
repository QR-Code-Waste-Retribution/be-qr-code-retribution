<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\PemungutTransaction;
use App\Models\Transaction;
use App\Models\UrbanVillage;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            DistrictSeeder::class,
            SubDistrictSeeder::class,
            RolesSeeder::class,
        ]);

        User::factory(300)->create();
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
        ]);
        Transaction::factory(100)->create();

        $this->call([
            PemungutTransactionsSeeder::class,
            UserCategorySeeder::class,
            InvoiceSeeder::class,
        ]);

    }
}
