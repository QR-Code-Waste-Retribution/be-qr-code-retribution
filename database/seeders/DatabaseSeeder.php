<?php

namespace Database\Seeders;

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
        // Transaction::factory(300)->create();

        $this->call([
            UserCategorySeeder::class,
            TestSeeder::class,
            TransactionInvoiceSeeder::class,
            // PemungutTransactionsSeeder::class,
        ]);

    }
}
