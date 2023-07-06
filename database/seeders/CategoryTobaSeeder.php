<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTobaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array(
            array("no" => "1", "name" => "Rumah Tangga", "price" => "5,000", "type" => "bulan"),
            array("no" => "2", "name" => "Kios atau tempat dagang", "price" => "15,000", "type" => "bulan"),
            array("no" => "3", "name" => "Rumah toko, kedai, rumah makan, apotik dan toko obat", "price" => "25000", "type" => "bulan"),
            array("no" => "4", "name" => "Restoran, losmen, hotel", "price" => "50000", "type" => "bulan"),
            array("no" => "5", "name" => "Kantor pemerintah/ swasta", "price" => "50000", "type" => "bulan"),
            array("no" => "6", "name" => "Kantor perbankan", "price" => "50000", "type" => "bulan"),
            array("no" => "7", "name" => "Sekolah negeri/swasta", "price" => "10000", "type" => "bulan"),
            array("no" => "8", "name" => "Rumah sakit pemerintah/ swasta", "price" => "300000", "type" => "bulan"),
            array("no" => "9", "name" => "Industri mekanis dan pergudangan", "price" => "25000", "type" => "bulan"),
            array("no" => "10", "name" => "Industri non mekanis", "price" => "15000", "type" => "bulan"),
            array("no" => "11", "name" => "Loket bus yang berada didalam terminal", "price" => "10000", "type" => "bulan"),
            array("no" => "12", "name" => "Gedung pertemuan", "price" => "100000", "type" => "bulan"),
            array("no" => "13", "name" => "Catering/ Jasa Boga", "price" => "50000", "type" => "bulan"),
            array("no" => "14", "name" => "SPBU/ Doorsmeer", "price" => "50000", "type" => "bulan"),
            array("no" => "15", "name" => "Supermarket/ Mini Market", "price" => "100000", "type" => "bulan"),
            array("no" => "16", "name" => "Klinik/ Balai Pengobatan/ Praktek Dokter", "price" => "60000", "type" => "bulan"),
            array("no" => "17", "name" => "Asrama Pendidikan kapasitas < 10 orang ", "price" => "20000", "type" => "bulan"),
            array("no" => "18", "name" => "Asrama Pendidikan kapasitas 11 s/d 20 orang", "price" => "30000", "type" => "bulan"),
            array("no" => "19", "name" => "Asrama Kapasitas > 20 orang", "price" => "100000", "type" => "bulan"),
            array("no" => "20", "name" => "Arena hiburan/ panggung hiburan rakyat", "price" => "100000", "type" => "bulan"),
            array("no" => "21", "name" => "Jajanan malam", "price" => "5000", "type" => "hari"),
            array("no" => "22", "name" => "Pedagang musiman", "price" => "10000", "type" => "hari"),
            array("no" => "23", "name" => "Pedagang pada saat hari pekan", "price" => "2000", "type" => "hari"),
            array("no" => "24", "name" => "Pembuangan sampah ke TPA oleh pihak ketiga", "price" => "50000", "type" => "hari"),
        );

        foreach ($categories as $item) {
            Category::create(
                [
                    'name' => $item['name'],
                    'description' => fake()->text(),
                    'price' => intval(implode('', explode(',', $item['price']))),
                    'type' => $item['type'] == 'bulan' ? "MONTH" : "DAY",
                    'district_id' => 1,
                ]
            );
        }
    }
}
