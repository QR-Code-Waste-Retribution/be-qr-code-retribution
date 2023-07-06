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
            CategoryTobaSeeder::class,
        ]);

        // User::factory(300)->create();
        $this->call([
            UserSeeder::class,
            InvoiceSeeder::class,
        ]);

        $this->call([
            // UserCategorySeeder::class,
            // TestUserCategorySeeder::class,
            // TestSeeder::class,
            // TransactionInvoiceSeeder::class,
            // PemungutTransactionsSeeder::class,
        ]);

    }
}
