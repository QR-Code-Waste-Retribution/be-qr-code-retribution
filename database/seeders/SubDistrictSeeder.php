<?php

namespace Database\Seeders;

use App\Models\SubDistrict;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kecamatan_kab_toba = [
            "Balige", "Tampahan", "Laguboti", "Habinsaran", "Borbor", "Nassau", 
            "Silaen", "Sigumpar", "Porsea", "Pintu Pohan Meranti", "Siantar Narumonda", 
            "Parmaksian", "Lumban Julu", "Uluan", "Ajibata", "Bonatua Lunasi", "TPA Pintu Bosi Laguboti", 
            "Perumahan DL Sitorus"
        ];

        foreach ($kecamatan_kab_toba as $item) {
            SubDistrict::create([
                'name' => $item,
                'district_id' => 1,
            ]);
        }
        
    }
}
