<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CardSize;
use App\Models\Category;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'title' => fake()->sentence(),
            'image' => fake()->imageUrl(),
            'music' => fake()->url(),
            'video' => fake()->url(),
            'description' => fake()->text(),
            // 'card_category_id' => Category::inRandomOrder()->first()->id,
            'card_size_id' => CardSize::inRandomOrder()->first()->id,
        ];
    }
}
