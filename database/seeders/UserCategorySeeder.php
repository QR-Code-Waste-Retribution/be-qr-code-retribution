<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $sub_district_user = array();
            $i = 0;
            while ($i < 3) {
                $categories = Category::select("id")
                    ->where('price', '!=', 0)
                    ->whereNotNull('parent_id')
                    ->where('district_id', $user->district_id)
                    ->inRandomOrder()
                    ->limit(1)
                    ->pluck('id')->toArray();
                $sub_district = SubDistrict::select("id")
                    ->where('district_id', $user->district_id)
                    ->inRandomOrder()
                    ->limit(1)
                    ->pluck('id')->toArray();
                if (in_array($sub_district[0], $sub_district_user)) {
                    $this->command->info("Category with sub district provided already exist [$i]");
                    $i--;
                    continue;
                }
                array_push($sub_district_user, $sub_district);
                // $this->command->info(sprintf('%s', json_encode($categories)));
                DB::table('users_categories')->insert([
                    ['user_id' => $user->id, 'category_id' => $categories[0], 'sub_district_id' => $sub_district[0], 'address' => fake()->address() . " " . $sub_district[0]],
                ]);
                $i++;
            }
            unset($sub_district_user);
        }
        $this->command->info(sprintf("Success to add dummy in users_categories table"));
    }
}
