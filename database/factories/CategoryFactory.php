<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'parent_id' => function () {
                if (Category::whereNull('parent_id')->exists()) {
                    $randomModel = Category::inRandomOrder()->first();
                    return $randomModel ? $randomModel->id : null;
                }
                return null;
            },
            'description' => fake()->text(),
            'price' => fake()->randomNumber() * 10000,
            'type' => fake()->randomElement(['month', 'day', 'package']),
            'district_id' => random_int(1, 3),
        ];
    }
}
