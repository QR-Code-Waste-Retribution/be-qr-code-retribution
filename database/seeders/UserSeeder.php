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
        $petugas = [
            'uuid' => fake()->uuid(), 
            'name' => 'Zico Andreas Aritonang',
            'username' => 'petugas',
            'password' => bcrypt('password'),
            'nik' => '217356253165323',
            'gender' => 'Laki-Laki',
            'address' => fake()->address(),
            'phoneNumber' => fake()->phoneNumber(),
            'sub_district_id' => 25,
            'district_id' => 2,  
            'role_id' => 3,
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
        $admin = [
            'uuid' => fake()->uuid(), 
            'name' => 'Zico Andreas Aritonang',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'nik' => '217356253165324',
            'gender' => 'Laki-Laki',
            'address' => fake()->address(),
            'phoneNumber' => fake()->phoneNumber(),
            'sub_district_id' => 25,
            'district_id' => 2,  
            'role_id' => 2,
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
        $masyarakat = [
            'uuid' => fake()->uuid(), 
            'name' => 'Zico Andreas Aritonang',
            'username' => 'masyarakat',
            'password' => bcrypt('password'),
            'nik' => '217356253165325',
            'gender' => 'Laki-Laki',
            'address' => fake()->address(),
            'phoneNumber' => fake()->phoneNumber(),
            'sub_district_id' => 25,
            'district_id' => 2,  
            'role_id' => 1,
            'status' => 1,
            'remember_token' => Str::random(10),
        ];

        User::create($petugas);
        User::create($admin);
        User::create($masyarakat);
    }
}
