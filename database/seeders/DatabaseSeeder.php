<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
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

        UrbanVillage::factory(100)->create();
        User::factory(50)->create();
        Transaction::factory(50)->create();

        $this->call([
            CategorySeeder::class,
            UserCategorySeeder::class,
            InvoiceSeeder::class,
        ]);

    }
}
