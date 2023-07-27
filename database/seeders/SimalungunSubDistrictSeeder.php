<?php

namespace Database\Seeders;

use App\Models\SubDistrict;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SimalungunSubDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kecamatan_kab_simalungun = [
            "Siantar", "Gunung Malela", "Gunung Maligas", "Bandar", "Bosar Maligas",
            "Pematang Bandar", "Ujung Padang", "Bandar Masilam", "Dolok Batu Nanggar",
            "Tapian Dolok", "Bandar Huluan", "Tanah Jawa", "Hatonduhan", "Hutabayuraja",
            "Jawamaraja Bahjambi", "Girsang Sipangan Bolon", "Dolok Panribuan",
            "Jorlang Hataran", "Sidamanik", "Pamatang Sidamanik", "Dolok Pardamean",
            "Silimakuta", "Pamatang Silimakuta", "Haranggaol Horison", "Dolok Silau",
            "Purba", "Raya", "Raya Kahean", "Silau Kahean", "Panei", "Panombeian Panei"
        ];

        foreach ($kecamatan_kab_simalungun as $item) {
            SubDistrict::create([
                'name' => $item,
                'district_id' => 2,
            ]);
        }
    }
}
