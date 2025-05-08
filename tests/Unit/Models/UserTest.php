<?php

namespace Tests\Unit\Models;

use App\Models\Card;
use App\Models\CardSize;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // S'assurer qu'il y a au moins une taille de carte dans la base de données
        CardSize::factory()->create();
    }

    #[Test]
    public function a_user_has_a_name_and_email()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
    }

    #[Test]
    public function a_user_has_a_role()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $regularUser = User::factory()->create([
            'role' => 'user'
        ]);

        $this->assertEquals('admin', $admin->role);
        $this->assertEquals('user', $regularUser->role);
    }

    #[Test]
    public function a_user_can_have_a_magic_number()
    {
        $user = User::factory()->create([
            'magic_number' => 42
        ]);

        $this->assertEquals(42, $user->magic_number);
    }

    #[Test]
    public function a_user_can_have_multiple_cards()
    {
        $user = User::factory()->create();
        Card::factory()->count(3)->create([
            'user_id' => $user->id
        ]);
        
        // Rafraîchir l'instance pour récupérer les cartes associées
        $user->refresh();

        $this->assertCount(3, $user->cards);
    }

    #[Test]
    public function user_password_is_hashed()
    {
        $password = 'password123';
        $user = User::factory()->create([
            'password' => $password
        ]);

        // Le mot de passe doit être hashé et donc différent de l'original
        $this->assertNotEquals($password, $user->password);

        // On peut vérifier qu'il commence par le format de hachage bcrypt
        $this->assertTrue(password_verify($password, $user->password));
    }
}
