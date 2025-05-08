<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Tests\TestCase;
use App\Models\Card;
use App\Models\User;
use App\Models\CardSize;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_can_view_cards_list()
    {
        // Créer un utilisateur avec le rôle admin
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Créer une taille de carte
        $cardSize = CardSize::factory()->create();
        
        // Créer quelques cartes pour tester
        $cards = Card::factory()->count(3)->create([
            'card_size_id' => $cardSize->id
        ]);
        
        // Faire une requête à la page de liste des cartes en tant qu'admin
        $response = $this->actingAs($admin)->get(route('admin.cards.list'));
        
        // Vérifier que la réponse est 200 OK
        $response->assertStatus(200);
        
        // Vérifier que la vue contient les cartes
        foreach ($cards as $card) {
            $response->assertSee($card->title);
        }
    }

    #[Test]
    public function non_admin_cannot_view_cards_list()
    {
        // Créer un utilisateur standard
        $user = User::factory()->create(['role' => 'user']);
        
        // Faire une requête à la page de liste des cartes en tant qu'utilisateur standard
        $response = $this->actingAs($user)->get(route('admin.cards.list'));
        
        // L'accès doit être refusé
        $response->assertStatus(403);
    }

    #[Test]
    public function admin_can_edit_card_size()
    {
        // Créer un utilisateur avec le rôle admin
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Créer deux tailles de carte
        $originalSize = CardSize::factory()->create();
        $newSize = CardSize::factory()->create();
        
        // Créer une carte avec la taille originale
        $card = Card::factory()->create([
            'card_size_id' => $originalSize->id
        ]);
        
        // Faire une requête GET pour accéder au formulaire d'édition de la carte
        $response = $this->actingAs($admin)->get(route('admin.cards.edit', $card));
        
        // Vérifier que la réponse est 200 OK
        $response->assertStatus(200);
        
        // Vérifier que la vue contient le formulaire avec les options de taille
        $response->assertSee($card->title);
        $response->assertSee($originalSize->name);
        $response->assertSee($newSize->name);
        
        // Données pour la mise à jour de la taille
        $updatedData = [
            'card_size_id' => $newSize->id
        ];
        
        // Faire une requête PUT pour mettre à jour la taille de la carte
        $updateResponse = $this->actingAs($admin)->put(route('admin.cards.update', $card), $updatedData);
        
        // Vérifier la redirection
        $updateResponse->assertRedirect(route('admin.cards.list'));
        
        // Vérifier que la taille de la carte a été mise à jour dans la base de données
        $this->assertDatabaseHas('cards', [
            'id' => $card->id,
            'card_size_id' => $newSize->id
        ]);
    }

    #[Test]
    public function admin_can_delete_a_card()
    {
        // Créer un utilisateur avec le rôle admin
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Créer une carte
        $card = Card::factory()->create();
        
        // Faire une requête DELETE pour supprimer la carte
        $response = $this->actingAs($admin)->delete(route('admin.cards.destroy', $card));
        
        // Vérifier la redirection
        $response->assertRedirect(route('admin.cards.list'));
        
        // Vérifier que la carte a été supprimée (ou soft deleted) de la base de données
        if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(Card::class))) {
            // Si la carte utilise SoftDeletes, elle devrait être soft deleted
            $this->assertSoftDeleted('cards', ['id' => $card->id]);
        } else {
            // Sinon, elle devrait être complètement supprimée
            $this->assertDatabaseMissing('cards', ['id' => $card->id]);
        }
    }

    #[Test]
    public function admin_can_only_update_card_size_not_other_attributes()
    {
        // Créer un utilisateur avec le rôle admin
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Créer deux tailles de carte
        $originalSize = CardSize::factory()->create();
        $newSize = CardSize::factory()->create();
        
        // Créer une carte avec des attributs originaux
        $card = Card::factory()->create([
            'title' => 'Titre Original',
            'description' => 'Description Originale',
            'card_size_id' => $originalSize->id
        ]);
        
        // Données pour la mise à jour avec tentative de modifier plus que la taille
        $updatedData = [
            'title' => 'Nouveau Titre',
            'description' => 'Nouvelle Description',
            'card_size_id' => $newSize->id
        ];
        
        // Faire une requête PUT pour mettre à jour la carte
        $updateResponse = $this->actingAs($admin)->put(route('admin.cards.update', $card), $updatedData);
        
        // Vérifier la redirection
        $updateResponse->assertRedirect(route('admin.cards.list'));
        
        // Vérifier que seule la taille de la carte a été mise à jour, pas les autres attributs
        $this->assertDatabaseHas('cards', [
            'id' => $card->id,
            'title' => 'Titre Original',
            'description' => 'Description Originale',
            'card_size_id' => $newSize->id
        ]);
    }
}
