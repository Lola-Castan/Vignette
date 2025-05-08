<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_can_view_categories_list()
    {
        // Créer un utilisateur avec le rôle admin
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Créer quelques catégories pour tester
        $categories = Category::factory()->count(3)->create();
        
        // Faire une requête à la page de liste des catégories en tant qu'admin
        $response = $this->actingAs($admin)->get(route('admin.categories.list'));
        
        // Vérifier que la réponse est 200 OK
        $response->assertStatus(200);
        
        // Vérifier que la vue contient les catégories
        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
    }

    #[Test]
    public function non_admin_cannot_view_categories_list()
    {
        // Créer un utilisateur standard
        $user = User::factory()->create(['role' => 'user']);
        
        // Faire une requête à la page de liste des catégories en tant qu'utilisateur standard
        $response = $this->actingAs($user)->get(route('admin.categories.list'));
        
        // L'accès doit être refusé
        $response->assertStatus(403);
    }

    #[Test]
    public function admin_can_create_a_category()
    {
        // Créer un utilisateur avec le rôle admin
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Données pour la nouvelle catégorie
        $categoryData = [
            'name' => 'Nouvelle Catégorie',
            'enabled' => '1'  // Envoyer comme une chaîne pour simuler l'input du formulaire
        ];
        
        // Faire une requête POST pour créer une nouvelle catégorie
        $response = $this->actingAs($admin)->post(route('admin.categories.store'), $categoryData);
        
        // Vérifier la redirection
        $response->assertRedirect(route('admin.categories.list'));
        
        // Vérifier que la catégorie a été créée dans la base de données
        $this->assertDatabaseHas('categories', ['name' => 'Nouvelle Catégorie']);
    }

    #[Test]
    public function admin_can_update_a_category()
    {
        // Créer un utilisateur avec le rôle admin
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Créer une catégorie
        $category = Category::factory()->create(['name' => 'Ancienne Catégorie']);
        
        // Données pour la mise à jour - ne pas inclure enabled désactive la catégorie
        $updatedData = [
            'name' => 'Catégorie Mise à Jour'
        ];
        
        // Faire une requête PUT pour mettre à jour la catégorie
        $response = $this->actingAs($admin)->put(route('admin.categories.update', $category), $updatedData);
        
        // Vérifier la redirection
        $response->assertRedirect(route('admin.categories.list'));
        
        // Vérifier que la catégorie a été mise à jour dans la base de données
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Catégorie Mise à Jour', 'enabled' => 0]);
    }

    #[Test]
    public function admin_can_delete_a_category()
    {
        // Créer un utilisateur avec le rôle admin
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Créer une catégorie
        $category = Category::factory()->create();
        
        // Faire une requête DELETE pour supprimer la catégorie
        $response = $this->actingAs($admin)->delete(route('admin.categories.destroy', $category));
        
        // Vérifier la redirection
        $response->assertRedirect(route('admin.categories.list'));
        
        // Vérifier que la catégorie a été supprimée de la base de données
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
