<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition()
    {
        $district = District::inRandomOrder()->first();
        $sub_district = 1;

        foreach ($district->sub_district_rand as $item){
            $sub_district = $item->id;

            break;
        }

        return [
            // 'uuid' => fake()->uuid(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->userName(),
            'nik' => fake()->unique()->numerify(),
            'gender' => fake()->randomElement(['Laki-Laki', 'Perempuan']),
            'address' => fake()->city(),
            'phoneNumber' => fake()->phoneNumber(),
            'urban_village_id' => random_int(1, 100),
            'district_id' => $district->id,
            'sub_district_id' => $sub_district,
            'role_id' => fake()->randomElement([1, 2, 3]),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
