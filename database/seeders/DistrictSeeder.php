<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts = [
            'Toba', 
            'Simalungun',
            'Samosir'
        ];

        foreach ($districts as $item) {
            District::create([
                'name' => $item,
            ]);
        }
    }
}
