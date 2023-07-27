<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySamosirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array(
            array("id" => "1", "name" => "Pemukiman", "description" => "lorem ipsum", "price" => "10000", "type" => "month", "district_id" => "3"),
            array("id" => "2", "name" => "Rumah Toko", "description" => "lorem ipsum", "price" => "20000", "type" => "month", "district_id" => "3"),
            array("id" => "3", "name" => "Minimarket Modern", "description" => "lorem ipsum", "price" => "150000", "type" => "month", "district_id" => "3"),
            array("id" => "4", "name" => "Bank, Pemerintah, Perkantoran, BUMN/BUMD, Swasta", "description" => "lorem ipsum", "price" => "100000", "type" => "month", "district_id" => "3"),
            array("id" => "5", "name" => "Salon/Pangkas, Bengkel, Apotek/Toko Obat, Fotocopy, Bimbel/Kursus", "description" => "lorem ipsum", "price" => "50000", "type" => "month", "district_id" => "3"),
            array("id" => "6", "name" => "Pedagang Sementara/Keliling", "description" => "lorem ipsum", "price" => "2000", "type" => "day", "district_id" => "3"),
            array("id" => "7", "name" => "Hotel/Losmen/Penginapan Jumlah kamar > 30", "description" => "lorem ipsum", "price" => "300000", "type" => "month", "district_id" => "3"),
            array("id" => "8", "name" => "Hotel/Losmen/Penginapan Jumlah kamar antara 15 sampai 30", "description" => "lorem ipsum", "price" => "200000", "type" => "month", "district_id" => "3"),
            array("id" => "9", "name" => "Hotel/Losmen/Penginapan Jumlah kamar di bawah 15", "description" => "lorem ipsum", "price" => "100000", "type" => "month", "district_id" => "3"),
            array("id" => "10", "name" => "Rumah Kost Jumlah kamar 5 sampai 10", "description" => "lorem ipsum", "price" => "50000", "type" => "month", "district_id" => "3"),
            array("id" => "11", "name" => "Rumah Kost Jumlah kamar 11 sampai 20", "description" => "lorem ipsum", "price" => "75000", "type" => "month", "district_id" => "3"),
            array("id" => "12", "name" => "Rumah Kost Jumlah kamar diatas 20", "description" => "lorem ipsum", "price" => "100000", "type" => "month", "district_id" => "3"),
            array("id" => "13", "name" => "Rumah makan/Restoran/Warung", "description" => "lorem ipsum", "price" => "50000", "type" => "month", "district_id" => "3"),
            array("id" => "14", "name" => "Usaha Transportasi/Wisata/Pusat Hiburan Loket/Pool angkutan", "description" => "lorem ipsum", "price" => "50000", "type" => "month", "district_id" => "3"),
            array("id" => "15", "name" => "Usaha Transportasi/Wisata/Pusat Hiburan Transportasi Danau", "description" => "lorem ipsum", "price" => "20000", "type" => "month", "district_id" => "3"),
            array("id" => "16", "name" => "Usaha Transportasi/Wisata/Pusat Hiburan Tempat Wisata", "description" => "lorem ipsum", "price" => "200000", "type" => "month", "district_id" => "3"),
            array("id" => "17", "name" => "Usaha Transportasi/Wisata/Pusat Hiburan Pusat Hiburan/Tontonan", "description" => "lorem ipsum", "price" => "100000", "type" => "month", "district_id" => "3"),
            array("id" => "18", "name" => "Rumah sakit pemerintah", "description" => "lorem ipsum", "price" => "500000", "type" => "month", "district_id" => "3"),
            array("id" => "19", "name" => "Rumah sakit swasta", "description" => "lorem ipsum", "price" => "200000", "type" => "month", "district_id" => "3"),
            array("id" => "20", "name" => "Puskesmas", "description" => "lorem ipsum", "price" => "100000", "type" => "month", "district_id" => "3"),
            array("id" => "21", "name" => "Balai Pengobatan/Praktek Medis", "description" => "lorem ipsum", "price" => "50000", "type" => "month", "district_id" => "3"),
            array("id" => "22", "name" => "Sekolah Jumlah siswa > 500 orang", "description" => "lorem ipsum", "price" => "200000", "type" => "month", "district_id" => "3"),
            array("id" => "23", "name" => "Sekolah Jumlah siswa 200 sampai 500", "description" => "lorem ipsum", "price" => "150000", "type" => "month", "district_id" => "3"),
            array("id" => "24", "name" => "Sekolah Jumlah siswa < 200 orang", "description" => "lorem ipsum", "price" => "100000", "type" => "month", "district_id" => "3"),
            array("id" => "25", "name" => "Acara insidentil di tepi jalan/ruang publik Dukacita", "description" => "lorem ipsum", "price" => "50000", "type" => "packet", "district_id" => "3"),
            array("id" => "26", "name" => "Acara insidentil di tepi jalan/ruang publik Sukacita", "description" => "lorem ipsum", "price" => "100000", "type" => "packet", "district_id" => "3"),
            array("id" => "27", "name" => "Acara insidentil di tepi jalan/ruang publik Pesta Besar/Syukuran/Kepanitiaan", "description" => "lorem ipsum", "price" => "200000", "type" => "packet", "district_id" => "3"),
            array("id" => "28", "name" => "Pemanfaatan Bak Sampah / Container", "description" => "lorem ipsum", "price" => "200000", "type" => "packet", "district_id" => "3"),
            array("id" => "29", "name" => "Pengelola Kawasan / Usaha yang Mengangkut Sampah secara langsung ke TPA", "description" => "lorem ipsum", "price" => "100000", "type" => "packet", "district_id" => "3"),
        );

        $type = [
            'month' => 'MONTH',
            'day' => 'DAY',
            'unit' => 'UNIT',
            'packet' => 'PACKET',
        ];

        foreach ($categories as $item) {
            Category::create(
                [
                    'name' => $item['name'],
                    'description' => fake()->text(),
                    'price' => intval(implode('', explode(',', $item['price']))),
                    'type' => $type[$item['type']],
                    'district_id' => 3,
                ]
            );
        }
    }
}
