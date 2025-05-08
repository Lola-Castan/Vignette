<?php

namespace Tests\Unit\Models;

use App\Models\Card;
use App\Models\CardSize;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // S'assurer qu'il y a au moins une taille de carte et un utilisateur dans la base de données
        CardSize::factory()->create();
        User::factory()->create();
    }

    #[Test]
    public function a_card_has_a_title()
    {
        $card = Card::factory()->create([
            'title' => 'Test Card Title'
        ]);

        $this->assertEquals('Test Card Title', $card->title);
    }

    #[Test]
    public function a_card_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $card = Card::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf(User::class, $card->user);
        $this->assertEquals($user->id, $card->user->id);
    }

    #[Test]
    public function a_card_belongs_to_a_card_size()
    {
        $cardSize = CardSize::factory()->create();
        $card = Card::factory()->create([
            'card_size_id' => $cardSize->id
        ]);

        $this->assertInstanceOf(CardSize::class, $card->cardSize);
        $this->assertEquals($cardSize->id, $card->cardSize->id);
    }

    #[Test]
    public function a_card_can_have_categories()
    {
        $card = Card::factory()->create();
        $category = Category::factory()->create();

        $card->categories()->attach($category);
        
        // Rafraîchir l'instance pour récupérer les catégories associées
        $card->refresh();

        $this->assertInstanceOf(Category::class, $card->categories->first());
        $this->assertEquals($category->id, $card->categories->first()->id);
    }

    #[Test]
    public function a_card_can_be_soft_deleted()
    {
        $card = Card::factory()->create();
        $cardId = $card->id;

        $card->delete();

        $this->assertSoftDeleted('cards', ['id' => $cardId]);
    }
}
