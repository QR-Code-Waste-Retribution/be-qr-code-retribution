<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PemungutTransaction>
 */
class PemungutTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'status' => random_int(0, 1),
            'pemungut_id' => User::inRandomOrder()->where('role_id', 2)->first(),
            'total' => 200000,
        ];
    }
}
