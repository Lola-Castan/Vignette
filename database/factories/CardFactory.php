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
        // Choix du type de carte : image seule, son seul, vidéo seule, ou image+son
        $type = fake()->randomElement(['image', 'music', 'video', 'image_music']);
        $data = [
            'user_id' => User::inRandomOrder()->first()->id,
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'card_size_id' => CardSize::inRandomOrder()->first()->id,
        ];
        if ($type === 'image') {
            $data['image'] = "storage/images/chat.png";
            $data['music'] = null;
            $data['video'] = null;
        // } elseif ($type === 'music') {
        //     $data['image'] = null;
        //     $data['music'] = fake()->url();
        //     $data['video'] = null;
        } elseif ($type === 'video') {
            $data['image'] = null;
            $data['music'] = null;
            $data['video'] = "storage/videos/rain.mp4";
        } elseif ($type === 'image_music') {
            $data['image'] = "storage/images/chatballon.png";
            $data['music'] = fake()->url();
            $data['video'] = null;
        }
        return $data;
    }
}
