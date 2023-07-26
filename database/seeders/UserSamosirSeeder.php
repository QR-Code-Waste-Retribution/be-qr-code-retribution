<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\SubDistrict;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSamosirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sub_district_id = SubDistrict::inRandomOrder()->where('district_id', 3)->first();


        $pemungut_samosir = [
            'uuid' => fake()->uuid(),
            'name' => 'heber',
            'username' => 'heber',
            'password' => bcrypt('password'),
            'nik' => '217356253165326',
            'gender' => 'Laki-Laki',
            'address' => fake()->address(),
            'phoneNumber' => fake()->phoneNumber(),
            'sub_district_id' => $sub_district_id->id,
            'district_id' => 3,
            'role_id' => 2,
            'account_status' => 1,
            'remember_token' => strval(random_int(100000, 999999)),
            'verification_status' => 1,
        ];
        
        $pemungut = User::create($pemungut_samosir);

        $m_samosir = [
            'uuid' => fake()->uuid(),
            'name' => 'Oinike',
            'username' => 'oinike',
            'password' => bcrypt('password'),
            'nik' => '217356253165327',
            'gender' => 'Laki-Laki',
            'address' => fake()->address(),
            'phoneNumber' => fake()->phoneNumber(),
            'sub_district_id' => $sub_district_id->id,
            'district_id' => 3,
            'role_id' => 1,
            'account_status' => 1,
            'remember_token' => strval(random_int(100000, 999999)),
            'verification_status' => 1,
        ];
        
        $masyarakat = User::create($m_samosir);

        DB::table('users_categories')->insert([
            [
                'user_id' => $masyarakat->id, 
                'category_id' => 77, 
                'sub_district_id' => $sub_district_id->id, 
                'address' => $masyarakat->address,
                'pemungut_id' => $pemungut->id,
            ],
        ]);


        $petugas_samosir = [
            'uuid' => fake()->uuid(),
            'name' => 'Petugas samosir',
            'username' => 'petugas_samosir',
            'password' => bcrypt('password'),
            'nik' => '217356253165328',
            'gender' => 'Laki-Laki',
            'address' => fake()->address(),
            'phoneNumber' => fake()->phoneNumber(),
            'sub_district_id' => 2,
            'district_id' => 3,
            'role_id' => 3,
            'account_status' => 1,
            'remember_token' => strval(random_int(100000, 999999)),
            'verification_status' => 1,
        ];

        User::create($petugas_samosir);
    }
}
