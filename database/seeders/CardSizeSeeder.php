<?php

namespace Database\Seeders;

use App\Models\CardSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = [
            ['name' => 'small', 'width' => 1, 'height' => 1],
            ['name' => 'medium', 'width' => 2, 'height' => 1],
            ['name' => 'large', 'width' => 2, 'height' => 2],
        ];

        foreach ($sizes as $size) {
            CardSize::create($size);
        }
    }
}