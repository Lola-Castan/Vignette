<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CardSize;
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
        
        // Récupère un CardSize ou en crée un nouveau si aucun n'existe
        $cardSizeId = CardSize::count() > 0 
            ? CardSize::inRandomOrder()->first()->id 
            : CardSize::factory()->create()->id;
            
        // Récupère un User ou en crée un nouveau si aucun n'existe
        $userId = User::count() > 0 
            ? User::inRandomOrder()->first()->id 
            : User::factory()->create()->id;
            
        $data = [
            'user_id' => $userId,
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'card_size_id' => $cardSizeId,
        ];
        
        if ($type === 'image') {
            $data['image'] = "storage/images/chat.png";
            $data['music'] = null;
            $data['video'] = null;
        } elseif ($type === 'music') {
            $data['image'] = null;
            $data['music'] = "storage/sounds/rain-sound.mp3";
            $data['video'] = null;
        } elseif ($type === 'video') {
            $data['image'] = null;
            $data['music'] = null;
            $data['video'] = "storage/videos/rain.mp4";
        } elseif ($type === 'image_music') {
            $data['image'] = "storage/images/chatballon.png";
            $data['music'] = "storage/sounds/rain-sound.mp3";
            $data['video'] = null;
        }
        return $data;
    }
}
