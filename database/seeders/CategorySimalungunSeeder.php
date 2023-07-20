<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySimalungunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array(
            array("id" => "1", "name" => "Perumahan A/ Kelas I di Pinggir Jalan Provinsi", "description" => "lorem ipsum", "price" => "3000", "type" => "month", "district_id" => "2"),
            array("id" => "2", "name" => "Perumahan B/ Kelas II di Jalan Kabupaten", "description" => "lorem ipsum", "price" => "2000", "type" => "month", "district_id" => "2"),
            array("id" => "3", "name" => "Perumahan C/ Kelas III di Jalan Penghubung", "description" => "lorem ipsum", "price" => "1500", "type" => "month", "district_id" => "2"),
            array("id" => "4", "name" => "Perumahan Perusahaan Perkebunan", "description" => "lorem ipsum", "price" => "1000", "type" => "month", "district_id" => "2"),
            array("id" => "5", "name" => "Pedagang Lesehan, Bajul PKS/Loads", "description" => "lorem ipsum", "price" => "1500", "type" => "month", "district_id" => "2"),
            array("id" => "6", "name" => "Toko Kecil", "description" => "lorem ipsum", "price" => "2500", "type" => "month", "district_id" => "2"),
            array("id" => "7", "name" => "Toko Sandang", "description" => "lorem ipsum", "price" => "6500", "type" => "month", "district_id" => "2"),
            array("id" => "8", "name" => "Toko Besar, Grosir, Travel/Biro", "description" => "lorem ipsum", "price" => "9000", "type" => "month", "district_id" => "2"),
            array("id" => "9", "name" => "Toko Emas", "description" => "lorem ipsum", "price" => "9000", "type" => "month", "district_id" => "2"),
            array("id" => "10", "name" => "Toko Buah", "description" => "lorem ipsum", "price" => "9000", "type" => "month", "district_id" => "2"),
            array("id" => "11", "name" => "Hotel Berbintang", "description" => "lorem ipsum", "price" => "75000", "type" => "month", "district_id" => "2"),
            array("id" => "12", "name" => "Bungalow", "description" => "lorem ipsum", "price" => "40000", "type" => "month", "district_id" => "2"),
            array("id" => "13", "name" => "Restoran", "description" => "lorem ipsum", "price" => "40000", "type" => "month", "district_id" => "2"),
            array("id" => "14", "name" => "Wisma", "description" => "lorem ipsum", "price" => "35000", "type" => "month", "district_id" => "2"),
            array("id" => "15", "name" => "Losmen", "description" => "lorem ipsum", "price" => "40000", "type" => "month", "district_id" => "2"),
            array("id" => "16", "name" => "Mess", "description" => "lorem ipsum", "price" => "35000", "type" => "month", "district_id" => "2"),
            array("id" => "17", "name" => "Perusahaan/Pabrik/Industri Volume Sampah 0.1 /d 1 ton per bulan", "description" => "lorem ipsum", "price" => "250000", "type" => "month", "district_id" => "2"),
            array("id" => "18", "name" => "Perusahaan/Pabrik/Industri Volume Sampah 1.1 s/d 2 ton per bulan", "description" => "lorem ipsum", "price" => "500000", "type" => "month", "district_id" => "2"),
            array("id" => "19", "name" => "Perusahaan/Pabrik/Industri Volume Sampah 2.1 s/d 3 ton per bulan", "description" => "lorem ipsum", "price" => "750000", "type" => "month", "district_id" => "2"),
            array("id" => "20", "name" => "Perusahaan/Pabrik/Industri Volume Sampah 3.1 s/d 4 ton per bulan", "description" => "lorem ipsum", "price" => "1000000", "type" => "month", "district_id" => "2"),
            array("id" => "21", "name" => "Perusahaan/Pabrik/Industri Volume Sampah 4.1 /d 5 ton per bulan", "description" => "lorem ipsum", "price" => "1250000", "type" => "month", "district_id" => "2"),
            array("id" => "22", "name" => "Perusahaan/Pabrik/Industri Volume Sampah lebih bear 5 ton per bulan", "description" => "lorem ipsum", "price" => "1500000", "type" => "month", "district_id" => "2"),
            array("id" => "23", "name" => "Penggilingan Padi Besar", "description" => "lorem ipsum", "price" => "39000", "type" => "month", "district_id" => "2"),
            array("id" => "24", "name" => "Penggilingan Padi Sedang", "description" => "lorem ipsum", "price" => "26000", "type" => "month", "district_id" => "2"),
            array("id" => "25", "name" => "Penggilingan Padi Kecil", "description" => "lorem ipsum", "price" => "9000", "type" => "month", "district_id" => "2"),
            array("id" => "26", "name" => "Penggilingan Padi Berjalan", "description" => "lorem ipsum", "price" => "20000", "type" => "month", "district_id" => "2"),
            array("id" => "27", "name" => "Rumah Makan", "description" => "lorem ipsum", "price" => "13000", "type" => "month", "district_id" => "2"),
            array("id" => "28", "name" => "Kedai Nasi", "description" => "lorem ipsum", "price" => "4500", "type" => "month", "district_id" => "2"),
            array("id" => "29", "name" => "Kedai Kopi", "description" => "lorem ipsum", "price" => "4500", "type" => "month", "district_id" => "2"),
            array("id" => "30", "name" => "Bioskop", "description" => "lorem ipsum", "price" => "20000", "type" => "month", "district_id" => "2"),
            array("id" => "31", "name" => "Billiard", "description" => "lorem ipsum", "price" => "9000", "type" => "month", "district_id" => "2"),
            array("id" => "32", "name" => "Salon Kecantikan", "description" => "lorem ipsum", "price" => "9000", "type" => "month", "district_id" => "2"),
            array("id" => "33", "name" => "Tempat Foto Copy", "description" => "lorem ipsum", "price" => "9000", "type" => "month", "district_id" => "2"),
            array("id" => "34", "name" => "Tukang Pangkas", "description" => "lorem ipsum", "price" => "2000", "type" => "month", "district_id" => "2"),
            array("id" => "35", "name" => "Tempat Rekreasi", "description" => "lorem ipsum", "price" => "20000", "type" => "month", "district_id" => "2"),
            array("id" => "36", "name" => "Pasar Malam/ Kesenian lainnya", "description" => "lorem ipsum", "price" => "20000", "type" => "packet", "district_id" => "2"),
            array("id" => "37", "name" => "Balai Pertemuan/ Gedung Serba Guna", "description" => "lorem ipsum", "price" => "20000", "type" => "packet", "district_id" => "2"),
            array("id" => "38", "name" => "Bengkel Roda 4 atau lebih", "description" => "lorem ipsum", "price" => "13000", "type" => "month", "district_id" => "2"),
            array("id" => "39", "name" => "Bengkel Roda 2 atau 3", "description" => "lorem ipsum", "price" => "9000", "type" => "month", "district_id" => "2"),
            array("id" => "40", "name" => "Tempat Pencucian Roda 2 dan 4", "description" => "lorem ipsum", "price" => "13000", "type" => "month", "district_id" => "2"),
            array("id" => "41", "name" => "Tempel Ban", "description" => "lorem ipsum", "price" => "5000", "type" => "month", "district_id" => "2"),
            array("id" => "42", "name" => "Gudang", "description" => "lorem ipsum", "price" => "20000", "type" => "month", "district_id" => "2"),
            array("id" => "43", "name" => "Panglong", "description" => "lorem ipsum", "price" => "20000", "type" => "month", "district_id" => "2"),
            array("id" => "44", "name" => "Koperasi", "description" => "lorem ipsum", "price" => "20000", "type" => "month", "district_id" => "2"),
            array("id" => "45", "name" => "Bangunan lain yang bersifat komersial", "description" => "lorem ipsum", "price" => "20000", "type" => "month", "district_id" => "2"),
            array("id" => "46", "name" => "Pemerintah", "description" => "lorem ipsum", "price" => "10000", "type" => "month", "district_id" => "2"),
            array("id" => "47", "name" => "Non Pemerintah/Swasta", "description" => "lorem ipsum", "price" => "10000", "type" => "month", "district_id" => "2"),
            array("id" => "48", "name" => "Kapal Bermotor yang mask dermaga per unit", "description" => "lorem ipsum", "price" => "10000", "type" => "month", "district_id" => "2"),
            array("id" => "49", "name" => "Pedagang Musiman pad Terminal dan jalan Protokol", "description" => "lorem ipsum", "price" => "1500", "type" => "day", "district_id" => "2"),
            array("id" => "50", "name" => "Bus Penumpang Umum Antar Desa", "description" => "lorem ipsum", "price" => "500", "type" => "unit", "district_id" => "2"),
            array("id" => "51", "name" => "Bus Penumpang Umum Antar Kabupaten / Kotamadia", "description" => "lorem ipsum", "price" => "1000", "type" => "unit", "district_id" => "2"),
            array("id" => "52", "name" => "Bus Penumpang Umum Antar Provinsi ", "description" => "lorem ipsum", "price" => "1500", "type" => "unit", "district_id" => "2"),
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
                    'district_id' => 2,
                ]
            );
        }
    }
}
