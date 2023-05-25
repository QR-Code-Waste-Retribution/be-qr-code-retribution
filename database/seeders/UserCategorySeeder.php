<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubDistrict;
use App\Models\User;
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
        $users = User::where('role_id', 1)->get();

        $this->addDummyData($users);
    }


    function addDummyData($users, $index = 0)
    {
        if ($index >= count($users)) {
            return;
        }

        $user = $users[$index];

        if ($user->role_id == 1) {
            $sub_district_user = array();
            $i = 0;

            while ($i < 3) {
                if ($i < 0) {
                    $i = 0;
                }

                $categories = Category::select("id")
                    ->where('price', '!=', 0)
                    ->whereNotNull('parent_id')
                    ->where('district_id', $user->district_id)
                    ->whereNotIn('type', ['DAY', 'PACKET', 'UNIT'])
                    ->inRandomOrder()
                    ->limit(1)
                    ->pluck('id')->toArray();

                $sub_district = SubDistrict::select("id")
                    ->where('district_id', $user->district_id)
                    ->inRandomOrder()
                    ->limit(1)
                    ->pluck('id')->toArray();

                $pemungut = User::select("id", "sub_district_id")
                    ->where('sub_district_id', $sub_district[0])
                    ->where('role_id', 2)
                    ->inRandomOrder()
                    ->limit(1)->first();

                if ($pemungut == null) {
                    // $this->command->info("Continue PEMUNGUT " . $i);
                    $i--;
                    continue;
                }

                if (in_array($sub_district[0], $sub_district_user)) {
                    // $this->command->info("Category with sub district provided already exist [$i]");
                    $i--;
                    continue;
                }

                // $this->command->info(json_encode($pemungut->id . " $i", JSON_PRETTY_PRINT));
                array_push($sub_district_user, $sub_district);

                DB::table('users_categories')->insert([
                    ['user_id' => $user->id, 'category_id' => $categories[0], 'sub_district_id' => $sub_district[0], 'address' => fake()->address() . " " . $sub_district[0], 
                    'pemungut_id' => $pemungut->id],
                ]);

                $i++;
            }

            unset($sub_district_user);
            // $this->command->info(sprintf("Success to add dummy in users_categories table"));
        }

        $this->addDummyData($users, $index + 1); // Recursive call for the next user
    }
}
