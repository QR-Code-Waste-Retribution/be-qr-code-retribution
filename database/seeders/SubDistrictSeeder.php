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
            "Aek Nabara", "Balige", "Bonatua Lunasi", 
            "Habinsaran", "Lumban Julu", "Porsea", 
            "Siantar Narumonda", "Sigumpar", "Torgamba"
        ];
        
        $kecamatan_kab_simalungun = [
            "Bandar", "Bandar Huluan", "Bandar Masilam", "Bosar Maligas", 
            "Dolog Masagal", "Dolok Batunanggar", "Dolok Panribuan", "Dolok Pardamean", 
            "Dolok Silau", "Girsang Sipangan Bolon", "Gunung Malela", "Gunung Maligas", 
            "Haranggaol Horison", "Hatonduhan", "Huta Bayu Raja", "Jawa Maraja Bah Jambi", 
            "Jorlang Hataran", "Panei", "Panombeian Panei", "Pematang Bandar", "Pematang Sidamanik", 
            "Pematang Silima Huta", "Purba", "Raya", "Raya Kahean", "Siantar", "Sidamanik", 
            "Silau Kahean", "Silimakuta", "Tanah Jawa", "Tapian Dolok", "Ujung Padang"
        ];

        $kecamatan_kab_samosir = [
            "Harian", "Nainggolan", "Onan Runggu", "Palipi", 
            "Pangururan", "Ronggur Nihuta", "Sianjur Mulamula", 
            "Simanindo", "Sitiotio"
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

        foreach ($kecamatan_kab_simalungun as $item) {
            SubDistrict::create([
                'name' => $item,
                'district_id' => 3,
            ]);
        }


        
    }
}
