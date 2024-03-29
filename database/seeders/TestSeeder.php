<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pemungut = User::where('username', 'pemungut_toba')->first();
        $sub_district_id = $pemungut->sub_district_id;
        $district_id = $pemungut->district_id;

        $users = User::where('role_id', 1)->where('district_id', $district_id)->limit(3)->orderBy('id', 'DESC')->get();

        $i = 1;
        foreach ($users as $user) {
            $categories = Category::inRandomOrder()->where('price', '!=', 0)
                ->where('type', "MONTH")
                ->where('district_id', $district_id)->limit($i)->get();

            foreach ($categories as $category) {
                DB::table('users_categories')->insert([
                    ['user_id' => $user->id, 'category_id' => $category->id, 'sub_district_id' => $sub_district_id, 'address' => fake()->address(), 'pemungut_id' => $pemungut->id],
                ]);
            }

            $i++;
        }

        $pemungut = User::where('username', 'pemungut_simalungun')->first();
        $sub_district_id = $pemungut->sub_district_id;
        $district_id = $pemungut->district_id;

        $users = User::where('role_id', 1)->where('district_id', $district_id)->limit(3)->orderBy('id', 'DESC')->get();

        $i = 1;
        foreach ($users as $user) {
            $categories = Category::inRandomOrder()->where('price', '!=', 0)
                ->where('type', "MONTH")
                ->where('district_id', $district_id)
                ->limit($i)->get();

            foreach ($categories as $category) {
                DB::table('users_categories')->insert([
                    ['user_id' => $user->id, 'category_id' => $category->id, 'sub_district_id' => $sub_district_id, 'address' => fake()->address(), 'pemungut_id' => $pemungut->id],
                ]);
            }

            $i++;
        }
    }
}
