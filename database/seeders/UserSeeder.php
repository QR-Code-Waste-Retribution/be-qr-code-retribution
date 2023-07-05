<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = config('users_masterdata')['users'];
        
        foreach ($users['pemungut'] as $item) {
            User::create([
                'uuid' => fake()->uuid(),
                'name' => $item['name'],
                'username' => strtolower(implode('_', explode(' ', $item['name']))),
                'password' => bcrypt('password'),
                'nik' => time() + random_int(100000, 999999),
                'gender' => $item['gender'],
                'address' => $item['address'],
                'phoneNumber' => $item['phoneNumber'],
                'sub_district_id' => $item['sub_district_id'],
                'district_id' => 1,
                'role_id' => 2,
                'account_status' => 1,
                'remember_token' => strval(random_int(100000, 999999)),
                'verification_status' => 1,
            ]);
        }
        
        foreach ($users['masyarakat'] as $item) {
            User::create([
                'uuid' => fake()->uuid(),
                'name' => $item['name'],
                'username' => $item['username'],
                'password' => bcrypt('password'),
                'nik' => time() + random_int(100000, 999999),
                'gender' => $item['gender'],
                'address' => $item['address'],
                'phoneNumber' => $item['phoneNumber'],
                'sub_district_id' => $item['sub_district_id'],
                'district_id' => $item['district_id'],
                'role_id' => 1,
                'account_status' => 1,
                'remember_token' => strval(random_int(100000, 999999)),
                'verification_status' => 1,
            ]);
        }

        $petugas_toba = [
            'uuid' => fake()->uuid(),
            'name' => 'Petugas Toba',
            'username' => 'petugas_toba',
            'password' => bcrypt('password'),
            'nik' => '217356253165323',
            'gender' => 'Laki-Laki',
            'address' => fake()->address(),
            'phoneNumber' => fake()->phoneNumber(),
            'sub_district_id' => 2,
            'district_id' => 1,
            'role_id' => 3,
            'account_status' => 1,
            'remember_token' => strval(random_int(100000, 999999)),
            'verification_status' => 1,
        ];
        User::create($petugas_toba);
    }
}
