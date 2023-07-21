<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTobaSeederStepTwo extends Seeder
{
    function removeSymbols($string)
    {
        // Define the regular expression pattern to match dots and other symbols
        $pattern = '/[.,\/#!$%\^&\*;:{}=\-_`~()]/';

        // Replace the matched symbols with an empty string
        return preg_replace($pattern, '', $string);
    }

    function getLastThreeDigits($number) {
        // Convert the number to a string to extract the last three digits
        $numberStr = (string) $number;
    
        // Use substr to get the last three characters
        $lastThreeDigits = substr($numberStr, -3);
    
        return $lastThreeDigits;
    }

    public function run()
    {
        $users = config('toba_new_data');

        $i = 1;

        foreach ($users as $item) {
            $username = $this->removeSymbols(strtolower(implode('_', explode(' ', $item['name']))));
            if (!$find = User::where('username', $username)->first()) {
                $user = User::create([
                    'uuid' => fake()->uuid(),
                    'name' => $item['name'],
                    'username' => $username,
                    'password' => bcrypt('password'),
                    'nik' => time() + $i,
                    'gender' => 'Laki-Laki',
                    'address' => $item['address'],
                    'phoneNumber' => time() + $i,
                    'sub_district_id' => $item['sub_district_id'],
                    'district_id' => $item['district_id'],
                    'role_id' => 1,
                    'account_status' => 1,
                    'remember_token' => strval(random_int(100000, 999999)),
                    'verification_status' => 1,
                ]);

                DB::table('users_categories')->insert([
                    [
                        'user_id' => $user->id,
                        'category_id' => $item['category_id'],
                        'sub_district_id' => $item['sub_district_id'],
                        'address' => isset($item['address']) ? $item['address'] : $item['address_uc'],
                        'pemungut_id' => $item['pemungut_id']
                    ],
                ]);
            } else {
                $user = User::create([
                    'uuid' => fake()->uuid(),
                    'name' => $item['name'],
                    'username' => $username . $this->getLastThreeDigits(time()),
                    'password' => bcrypt('password'),
                    'nik' => time() + $i,
                    'gender' => 'Laki-Laki',
                    'address' => $item['address'],
                    'phoneNumber' => time() + $i,
                    'sub_district_id' => $item['sub_district_id'],
                    'district_id' => $item['district_id'],
                    'role_id' => 1,
                    'account_status' => 1,
                    'remember_token' => strval(random_int(100000, 999999)),
                    'verification_status' => 1,
                ]);

                DB::table('users_categories')->insert([
                    [
                        'user_id' => $user->id,
                        'category_id' => $item['category_id'],
                        'sub_district_id' => $item['sub_district_id'],
                        'address' => isset($item['address']) ? $item['address'] : $item['address_uc'],
                        'pemungut_id' => $item['pemungut_id']
                    ],
                ]);
            }
            $i++;
        }
    }
}
