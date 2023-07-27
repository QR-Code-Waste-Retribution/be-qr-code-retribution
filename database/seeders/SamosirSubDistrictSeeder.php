<?php

namespace Database\Seeders;

use App\Models\SubDistrict;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SamosirSubDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $kecamatan_kab_samosir = [
            "Harian", "Nainggolan", "Onan Runggu", "Palipi", 
            "Pangururan", "Ronggur Nihuta", "Sianjur Mulamula", 
            "Simanindo", "Sitio-tio"
        ];

        foreach ($kecamatan_kab_samosir as $item) {
            SubDistrict::create([
                'name' => $item,
                'district_id' => 3,
            ]);
        }
    }
}
