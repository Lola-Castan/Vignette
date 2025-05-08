<?php

namespace Tests\Unit\Models;

use App\Models\Card;
use App\Models\CardSize;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CardSizeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // S'assurer qu'il y a au moins une taille de carte dans la base de données
        CardSize::factory()->create();
    }

    #[Test]
    public function a_card_size_has_a_name_width_and_height()
    {
        $cardSize = CardSize::factory()->create([
            'name' => 'Medium',
            'width' => 200,
            'height' => 150
        ]);

        $this->assertEquals('Medium', $cardSize->name);
        $this->assertEquals(200, $cardSize->width);
        $this->assertEquals(150, $cardSize->height);
    }

    #[Test]
    public function a_card_size_can_have_multiple_cards()
    {
        $cardSize = CardSize::factory()->create();
        Card::factory()->count(3)->create([
            'card_size_id' => $cardSize->id
        ]);

        // Rafraîchir l'instance pour récupérer les cartes associées
        $cardSize->refresh();

        $this->assertCount(3, $cardSize->cards);
        $this->assertInstanceOf(Card::class, $cardSize->cards->first());
    }
}
