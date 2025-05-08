<?php

namespace Database\Factories;

use App\Models\CardSize;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CardSize>
 */
class CardSizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Générer différentes tailles de cartes
        $sizes = [
            'small' => ['width' => 100, 'height' => 100],
            'medium' => ['width' => 200, 'height' => 150],
            'large' => ['width' => 300, 'height' => 200],
            'wide' => ['width' => 400, 'height' => 150],
            'tall' => ['width' => 150, 'height' => 300],
        ];

        $sizeName = fake()->randomElement(array_keys($sizes));
        $size = $sizes[$sizeName];

        return [
            'name' => $sizeName,
            'width' => $size['width'],
            'height' => $size['height'],
        ];
    }
}
