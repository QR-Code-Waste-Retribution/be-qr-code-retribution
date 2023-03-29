<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $reference_number = 'REF-' . date('Ymd') . '-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4) . '-' . substr(str_shuffle('1234567890'), 0, 7);
        $transaction_number = 'TRAN-' . date('Ymd') . '-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5) . '-' . substr(str_shuffle('1234567890'), 0, 7);

        return [
            'price' => fake()->randomElement([10000, 20000, 30000, 40000, 50000]),
            'status' => '0',
            'date' => now(),
            'type' => fake()->randomElement(['CASH', 'NONCASH']),
            'reference_number' => $reference_number,
            'transaction_number' => $transaction_number,
            'user_id' => User::inRandomOrder()->first(),
            'pemungut_id' => User::inRandomOrder()->where('role_id', 2)->first(),
        ];
    }
}
