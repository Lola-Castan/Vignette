<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Card;
use App\Models\CardSize;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CardControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_delete_their_own_card()
    {
        // Créer un utilisateur
        $user = User::factory()->create();
        
        // Créer une taille de carte
        $cardSize = CardSize::factory()->create();
        
        // Créer une carte appartenant à cet utilisateur
        $card = Card::factory()->create([
            'user_id' => $user->id,
            'card_size_id' => $cardSize->id
        ]);
        
        // Faire une requête DELETE pour supprimer la carte
        $response = $this->actingAs($user)->delete(route('cards_delete', $card->id));
        
        // Vérifier la redirection vers la liste des cartes (qui est la page d'accueil)
        $response->assertRedirect(route('cards_list'));
        
        // Vérifier que la carte a été supprimée ou soft deleted
        if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(Card::class))) {
            $this->assertSoftDeleted('cards', ['id' => $card->id]);
        } else {
            $this->assertDatabaseMissing('cards', ['id' => $card->id]);
        }
    }
    
    #[Test]
    public function user_cannot_delete_others_card()
    {
        // Créer deux utilisateurs
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        // Créer une taille de carte
        $cardSize = CardSize::factory()->create();
        
        // Créer une carte appartenant au premier utilisateur
        $card = Card::factory()->create([
            'user_id' => $user1->id,
            'card_size_id' => $cardSize->id
        ]);
        
        // Tenter de supprimer la carte en tant que deuxième utilisateur
        $response = $this->actingAs($user2)->delete(route('cards_delete', $card->id));
        
        // Vérifier que l'accès est refusé
        $response->assertForbidden();
        
        // Vérifier que la carte existe toujours
        $this->assertDatabaseHas('cards', ['id' => $card->id]);
    }
    
    #[Test]
    public function admin_can_delete_any_card()
    {
        // Créer un utilisateur standard et un admin
        $user = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Créer une taille de carte
        $cardSize = CardSize::factory()->create();
        
        // Créer une carte appartenant à l'utilisateur standard
        $card = Card::factory()->create([
            'user_id' => $user->id,
            'card_size_id' => $cardSize->id
        ]);
        
        // Tenter de supprimer la carte en tant qu'admin
        $response = $this->actingAs($admin)->delete(route('cards_delete', $card->id));
        
        // Vérifier la redirection
        $response->assertRedirect();
        
        // Vérifier que la carte a été supprimée ou soft deleted
        if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(Card::class))) {
            $this->assertSoftDeleted('cards', ['id' => $card->id]);
        } else {
            $this->assertDatabaseMissing('cards', ['id' => $card->id]);
        }
    }
    
    #[Test]
    public function guest_cannot_delete_any_card()
    {
        // Créer un utilisateur
        $user = User::factory()->create();
        
        // Créer une taille de carte
        $cardSize = CardSize::factory()->create();
        
        // Créer une carte
        $card = Card::factory()->create([
            'user_id' => $user->id,
            'card_size_id' => $cardSize->id
        ]);
        
        // Tenter de supprimer la carte sans être connecté
        $response = $this->delete(route('cards_delete', $card->id));
        
        // Vérifier la redirection vers la page de connexion
        $response->assertRedirect(route('login'));
        
        // Vérifier que la carte existe toujours
        $this->assertDatabaseHas('cards', ['id' => $card->id]);
    }
    
    #[Test]
    public function user_can_view_create_card_form()
    {
        // Créer un utilisateur
        $user = User::factory()->create();
        
        // Accéder au formulaire de création de carte
        $response = $this->actingAs($user)->get(route('cards_create'));
        
        // Vérifier que la page s'affiche correctement
        $response->assertStatus(200);
        $response->assertViewIs('cards.create');
    }
    
    #[Test]
    public function user_can_edit_their_own_card()
    {
        // Créer un utilisateur
        $user = User::factory()->create();
        
        // Créer une taille de carte
        $cardSize = CardSize::factory()->create();
        
        // Créer une carte appartenant à cet utilisateur
        $card = Card::factory()->create([
            'user_id' => $user->id,
            'card_size_id' => $cardSize->id
        ]);
        
        // Accéder au formulaire d'édition
        $response = $this->actingAs($user)->get(route('cards_edit', $card->id));
        
        // Vérifier que la page s'affiche correctement
        $response->assertStatus(200);
        $response->assertViewIs('cards.edit');
        $response->assertSee($card->title);
    }
    
    #[Test]
    public function user_cannot_edit_others_card()
    {
        // Créer deux utilisateurs
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        // Créer une taille de carte
        $cardSize = CardSize::factory()->create();
        
        // Créer une carte appartenant au premier utilisateur
        $card = Card::factory()->create([
            'user_id' => $user1->id,
            'card_size_id' => $cardSize->id
        ]);
        
        // Tenter d'accéder au formulaire d'édition en tant que deuxième utilisateur
        $response = $this->actingAs($user2)->get(route('cards_edit', $card->id));
        
        // Vérifier que l'accès est refusé
        $response->assertForbidden();
    }
}
