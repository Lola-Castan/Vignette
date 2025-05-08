<?php

namespace Tests\Unit\Models;

use App\Models\Card;
use App\Models\CardSize;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // S'assurer qu'il y a au moins un utilisateur et une taille de carte pour créer des cartes
        User::factory()->create();
        CardSize::factory()->create();
    }

    #[Test]
    public function a_category_has_a_name()
    {
        $category = Category::factory()->create([
            'name' => 'Test Category'
        ]);

        $this->assertEquals('Test Category', $category->name);
    }

    #[Test]
    public function a_category_can_have_multiple_cards()
    {
        $category = Category::factory()->create();
        $cards = Card::factory()->count(3)->create();

        // Attacher les cartes à la catégorie
        $category->cards()->attach($cards->pluck('id'));
        
        // Rafraîchir l'instance pour récupérer les cartes associées
        $category->refresh();

        $this->assertCount(3, $category->cards);
        $this->assertInstanceOf(Card::class, $category->cards->first());
    }

    #[Test]
    public function a_category_can_be_enabled_or_disabled()
    {
        $enabledCategory = Category::factory()->create([
            'enabled' => true
        ]);

        $disabledCategory = Category::factory()->create([
            'enabled' => false
        ]);

        $this->assertTrue($enabledCategory->enabled);
        $this->assertFalse($disabledCategory->enabled);
    }
}
