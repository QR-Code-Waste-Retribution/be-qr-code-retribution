<?php

namespace Database\Seeders;

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
            SamosirSubDistrictSeeder::class,
            SimalungunSubDistrictSeeder::class,
            RolesSeeder::class,
            CategoryTobaSeeder::class,
            CategorySimalungunSeeder::class,
            CategorySamosirSeeder::class,
        ]);

        // $this->call([
        //     UserTobaSeeder::class,
        //     UserSimalungunSeeder::class,
        //     UserSamosirSeeder::class,

        //     InvoiceTobaSeeder::class,
        // ]);

        // UserCategorySeeder::class,
        // TestUserCategorySeeder::class,
        // TestSeeder::class,
        // TransactionInvoiceSeeder::class,
        // PemungutTransactionsSeeder::class,

    }
}
