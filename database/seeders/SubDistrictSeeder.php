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
            "Parmaksian", "Lumban Julu", "Uluan", "Ajibata", "Bonatua Lunasi"
        ];
        
        $kecamatan_kab_simalungun = [
            "Siantar", "Gunung Malela", "Gunung Maligas", "Bandar", "Bosar Maligas", 
            "Pematang Bandar", "Ujung Padang", "Bandar Masilam", "Dolok Batu Nanggar", 
            "Tapian Dolok", "Bandar Huluan", "Tanah Jawa", "Hatonduhan", "Hutabayuraja", 
            "Jawamaraja Bahjambi", "Girsang Sipangan Bolon", "Dolok Panribuan",
            "Jorlang Hataran", "Sidamanik", "Pamatang Sidamanik", "Dolok Pardamean", 
            "Silimakuta", "Pamatang Silimakuta", "Haranggaol Horison", "Dolok Silau", 
            "Purba", "Raya", "Raya Kahean", "Silau Kahean", "Panei", "Panombeian Panei"
        ];

        $kecamatan_kab_samosir = [
            "Harian", "Nainggolan", "Onan Runggu", "Palipi", 
            "Pangururan", "Ronggur Nihuta", "Sianjur Mulamula", 
            "Simanindo", "Sitio-tio"
        ];


        foreach ($kecamatan_kab_toba as $item) {
            SubDistrict::create([
                'name' => $item,
                'district_id' => 1,
            ]);
        }

        foreach ($kecamatan_kab_simalungun as $item) {
            SubDistrict::create([
                'name' => $item,
                'district_id' => 2,
            ]);
        }

        foreach ($kecamatan_kab_samosir as $item) {
            SubDistrict::create([
                'name' => $item,
                'district_id' => 3,
            ]);
        }


        
    }
}
