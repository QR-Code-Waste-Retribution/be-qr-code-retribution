<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['masyarakat', 'pemungut', 'petugas_kabupaten'];

        foreach ($roles as $item) {
            Role::create([
                'name' => $item,
            ]);
        }
    }
}
