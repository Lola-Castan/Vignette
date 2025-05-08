<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_can_view_users_list()
    {
        // Créer un utilisateur avec le rôle admin
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Créer quelques utilisateurs standards pour tester
        $users = User::factory()->count(3)->create(['role' => 'user']);
        
        // Faire une requête à la page de liste des utilisateurs en tant qu'admin
        $response = $this->actingAs($admin)->get(route('admin.users.list'));
        
        // Vérifier que la réponse est 200 OK
        $response->assertStatus(200);
        
        // Vérifier que la vue contient les utilisateurs
        foreach ($users as $user) {
            $response->assertSee($user->name);
            $response->assertSee($user->email);
        }
    }

    #[Test]
    public function non_admin_cannot_view_users_list()
    {
        // Créer un utilisateur standard
        $user = User::factory()->create(['role' => 'user']);
        
        // Faire une requête à la page de liste des utilisateurs en tant qu'utilisateur standard
        $response = $this->actingAs($user)->get(route('admin.users.list'));
        
        // L'accès doit être refusé
        $response->assertStatus(403);
    }

    #[Test]
    public function admin_can_create_a_user()
    {
        // Créer un utilisateur avec le rôle admin
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Générer un magic_number unique
        $uniqueMagicNumber = rand(1000, 9999);
        
        // Données pour le nouvel utilisateur
        $userData = [
            'name' => 'Nouvel Utilisateur',
            'email' => 'nouvel.utilisateur@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'magic_number' => $uniqueMagicNumber
        ];
        
        // Faire une requête POST pour créer un nouvel utilisateur
        $response = $this->actingAs($admin)->post(route('admin.users.store'), $userData);
        
        // Vérifier la redirection
        $response->assertRedirect(route('admin.users.list'));
        $response->assertSessionHas('success');
        
        // Vérifier que l'utilisateur a été créé dans la base de données avec le rôle 'user'
        $this->assertDatabaseHas('users', [
            'name' => 'Nouvel Utilisateur',
            'email' => 'nouvel.utilisateur@example.com',
            'role' => 'user',  // Le rôle est toujours 'user' peu importe ce qui est envoyé
            'magic_number' => $uniqueMagicNumber
        ]);
        
        // Vérifier que le mot de passe a été hashé
        $user = User::where('email', 'nouvel.utilisateur@example.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    #[Test]
    public function admin_can_update_a_user()
    {
        // Créer un utilisateur avec le rôle admin
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Créer un utilisateur standard à modifier
        $user = User::factory()->create([
            'name' => 'Utilisateur Original',
            'email' => 'original@example.com',
            'role' => 'user'
        ]);
        
        // Données pour la mise à jour
        $updatedData = [
            'name' => 'Utilisateur Modifié',
            'email' => 'modifie@example.com',
            'role' => 'user',
            'magic_number' => 99
        ];
        
        // Faire une requête PUT pour mettre à jour l'utilisateur
        $response = $this->actingAs($admin)->put(route('admin.users.update', $user), $updatedData);
        
        // Vérifier la redirection
        $response->assertRedirect(route('admin.users.list'));
        
        // Vérifier que l'utilisateur a été mis à jour dans la base de données
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Utilisateur Modifié',
            'email' => 'modifie@example.com',
            'magic_number' => 99
        ]);
    }

    #[Test]
    public function admin_can_delete_a_user()
    {
        // Créer un utilisateur avec le rôle admin
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Créer un utilisateur standard à supprimer
        $user = User::factory()->create();
        
        // Faire une requête DELETE pour supprimer l'utilisateur
        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $user));
        
        // Vérifier la redirection
        $response->assertRedirect(route('admin.users.list'));
        
        // Vérifier que l'utilisateur a été supprimé de la base de données
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    #[Test]
    public function admin_cannot_delete_themselves()
    {
        // Créer un utilisateur avec le rôle admin
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Essayer de supprimer son propre compte
        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin));
        
        // Vérifier la redirection avec message d'erreur
        $response->assertRedirect(route('admin.users.list'));
        $response->assertSessionHas('error');
        
        // Vérifier que l'admin existe toujours dans la base de données
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    #[Test]
    public function role_cannot_be_changed()
    {
        // Créer un utilisateur avec le rôle admin
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Créer un utilisateur standard
        $user = User::factory()->create(['role' => 'user']);
        
        // Essayer de changer le rôle de l'utilisateur standard en admin
        $updatedData = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => 'admin', // tentative de changement de rôle qui ne devrait pas fonctionner
            'magic_number' => $user->magic_number
        ];
        
        // Faire une requête PUT pour mettre à jour l'utilisateur
        $response = $this->actingAs($admin)->put(route('admin.users.update', $user), $updatedData);
        
        // Vérifier la redirection vers la liste des utilisateurs
        $response->assertRedirect(route('admin.users.list'));
        
        // Vérifier que l'utilisateur a toujours le rôle 'user'
        $this->assertDatabaseHas('users', ['id' => $user->id, 'role' => 'user']);
        
        // Essayer de changer le rôle de l'admin en utilisateur standard
        $adminUpdatedData = [
            'name' => $admin->name,
            'email' => $admin->email,
            'role' => 'user', // tentative de changement de rôle qui ne devrait pas fonctionner
            'magic_number' => $admin->magic_number
        ];
        
        // Faire une requête PUT pour mettre à jour l'admin
        $response = $this->actingAs($admin)->put(route('admin.users.update', $admin), $adminUpdatedData);
        
        // Vérifier la redirection vers la liste des utilisateurs
        $response->assertRedirect(route('admin.users.list'));
        
        // Vérifier que l'admin a toujours le rôle 'admin'
        $this->assertDatabaseHas('users', ['id' => $admin->id, 'role' => 'admin']);
    }
}
