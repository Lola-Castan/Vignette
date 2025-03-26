<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CardSize;
use App\Models\Category;

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
            'title' => fake()->title(),
            'image' => fake()->imageUrl(),
            'music' => fake()->url(),
            'video' => fake()->url(),
            'description' => fake()->text(),
            'category_id' => Category::factory(),
            'card_size_id' => CardSize::factory(),
        ];
    }
}
