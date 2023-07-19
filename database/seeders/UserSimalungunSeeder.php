<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\SubDistrict;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSimalungunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sub_district_id = SubDistrict::inRandomOrder()->where('district_id', 2)->first();


        $pemungut_simalungun = [
            'uuid' => fake()->uuid(),
            'name' => 'Andreas',
            'username' => 'andreas',
            'password' => bcrypt('password'),
            'nik' => '2173562531652378',
            'gender' => 'Laki-Laki',
            'address' => fake()->address(),
            'phoneNumber' => fake()->phoneNumber(),
            'sub_district_id' => $sub_district_id->id,
            'district_id' => 2,
            'role_id' => 2,
            'account_status' => 1,
            'remember_token' => strval(random_int(100000, 999999)),
            'verification_status' => 1,
        ];
        
        $pemungut = User::create($pemungut_simalungun);

        $m_simalungun = [
            'uuid' => fake()->uuid(),
            'name' => 'Aritonang',
            'username' => 'aritonang',
            'password' => bcrypt('password'),
            'nik' => '217356253165324',
            'gender' => 'Laki-Laki',
            'address' => fake()->address(),
            'phoneNumber' => fake()->phoneNumber(),
            'sub_district_id' => $sub_district_id->id,
            'district_id' => 2,
            'role_id' => 1,
            'account_status' => 1,
            'remember_token' => strval(random_int(100000, 999999)),
            'verification_status' => 1,
        ];
        
        $masyarakat = User::create($m_simalungun);

        DB::table('users_categories')->insert([
            [
                'user_id' => $masyarakat->id, 
                'category_id' => 25, 
                'sub_district_id' => $sub_district_id->id, 
                'address' => $masyarakat->address,
                'pemungut_id' => $pemungut->id,
            ],
        ]);

        Invoice::create([
            'category_id' => 25,
            'price' => 3000,
            'user_id' => $masyarakat->id,
            'uuid_user' => $masyarakat->uuid,
            'masyarakat_transaction_id' => null,
            'status' => 0,
        ]);

        $petugas_simalungun = [
            'uuid' => fake()->uuid(),
            'name' => 'Petugas Simalungun',
            'username' => 'petugas_simalungun',
            'password' => bcrypt('password'),
            'nik' => '217356253165325',
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

        User::create($petugas_simalungun);
    }
}
