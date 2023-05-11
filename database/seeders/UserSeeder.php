<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $petugas_toba = [
            'uuid' => fake()->uuid(), 
            'name' => 'Zico Andreas Aritonang',
            'username' => 'petugas',
            'password' => bcrypt('password'),
            'nik' => '217356253165323',
            'gender' => 'Laki-Laki',
            'address' => fake()->address(),
            'phoneNumber' => fake()->phoneNumber(),
            'sub_district_id' => 2,
            'district_id' => 1,  
            'role_id' => 3,
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
        $pemungut_toba = [
            'uuid' => fake()->uuid(), 
            'name' => 'Pemungut A',
            'username' => 'pemungut',
            'password' => bcrypt('password'),
            'nik' => '217356253165324',
            'gender' => 'Laki-Laki',
            'address' => fake()->address(),
            'phoneNumber' => fake()->phoneNumber(),
            'sub_district_id' => 2,
            'district_id' => 1,  
            'role_id' => 2,
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
        $masyarakatA_toba = [
            'uuid' => fake()->uuid(), 
            'name' => 'Zico',
            'username' => 'masyarakatA',
            'password' => bcrypt('password'),
            'nik' => '217356253165325',
            'gender' => 'Laki-Laki',
            'address' => fake()->address(),
            'phoneNumber' => fake()->phoneNumber(),
            'sub_district_id' => 2,
            'district_id' => 1,  
            'role_id' => 1,
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
        $masyarakatB_toba = [
            'uuid' => fake()->uuid(), 
            'name' => 'Andreas',
            'username' => 'masyarakatB',
            'password' => bcrypt('password'),
            'nik' => '217356253165326',
            'gender' => 'Laki-Laki',
            'address' => fake()->address(),
            'phoneNumber' => fake()->phoneNumber(),
            'sub_district_id' => 2,
            'district_id' => 1,  
            'role_id' => 1,
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
        $masyarakatC_toba = [
            'uuid' => fake()->uuid(), 
            'name' => 'Aritonang',
            'username' => 'masyarakatC',
            'password' => bcrypt('password'),
            'nik' => '217356253165327',
            'gender' => 'Laki-Laki',
            'address' => fake()->address(),
            'phoneNumber' => fake()->phoneNumber(),
            'sub_district_id' => 2,
            'district_id' => 1,  
            'role_id' => 1,
            'status' => 1,
            'remember_token' => Str::random(10),
        ];


        // $petugas_sima = [
        //     'uuid' => fake()->uuid(), 
        //     'name' => 'Petugas SIMA',
        //     'username' => 'petugas',
        //     'password' => bcrypt('password'),
        //     'nik' => '217356253165323',
        //     'gender' => 'Laki-Laki',
        //     'address' => fake()->address(),
        //     'phoneNumber' => fake()->phoneNumber(),
        //     'sub_district_id' => 10,
        //     'district_id' => 2,  
        //     'role_id' => 3,
        //     'status' => 1,
        //     'remember_token' => Str::random(10),
        // ];
        // $pemungut_sima = [
        //     'uuid' => fake()->uuid(), 
        //     'name' => 'Pemungut SIMA',
        //     'username' => 'pemungut',
        //     'password' => bcrypt('password'),
        //     'nik' => '217356253165324',
        //     'gender' => 'Laki-Laki',
        //     'address' => fake()->address(),
        //     'phoneNumber' => fake()->phoneNumber(),
        //     'sub_district_id' => 10,
        //     'district_id' => 2,  
        //     'role_id' => 2,
        //     'status' => 1,
        //     'remember_token' => Str::random(10),
        // ];
        // $masyarakatA_sima = [
        //     'uuid' => fake()->uuid(), 
        //     'name' => 'Zico SIMA',
        //     'username' => 'masyarakatA',
        //     'password' => bcrypt('password'),
        //     'nik' => '217356253165325',
        //     'gender' => 'Laki-Laki',
        //     'address' => fake()->address(),
        //     'phoneNumber' => fake()->phoneNumber(),
        //     'sub_district_id' => 10,
        //     'district_id' => 2,  
        //     'role_id' => 1,
        //     'status' => 1,
        //     'remember_token' => Str::random(10),
        // ];

        User::create($petugas_toba);
        User::create($pemungut_toba);
        User::create($masyarakatA_toba);
        User::create($masyarakatB_toba);
        User::create($masyarakatC_toba);
       
        // User::create($petugas_sima);
        // User::create($pemungut_sima);
        // User::create($masyarakatA_sima);
    }
}
