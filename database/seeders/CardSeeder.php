<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Card;
use App\Models\Category;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Card::factory()->count(15)->create()->each(function ($card) {
            $categories = Category::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $card->categories()->attach($categories);
        });
    }
}
