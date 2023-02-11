<?php

namespace Database\Seeders;

use App\Models\Category;
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
            $categories = Category::select("id")->inRandomOrder()->limit(3)->pluck('id')->toArray();
            $this->command->info(sprintf('%s', json_encode($categories)));
            DB::table('users_categories')->insert([
                ['user_id' => $user->id, 'category_id' => $categories[0]],
                ['user_id' => $user->id, 'category_id' => $categories[1]],
                ['user_id' => $user->id, 'category_id' => $categories[2]]
            ]);
        }
        $this->command->info(sprintf("Success to add dummy in users_categories table"));
    }
}
