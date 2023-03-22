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

        User::create($petugas);
    }
}
