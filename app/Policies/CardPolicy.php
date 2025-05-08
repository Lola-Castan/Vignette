<?php

namespace App\Policies;

use App\Models\Card;
use App\Models\User;

class CardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Tout le monde peut voir la liste des cartes
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Card $card): bool
    {
        return true; // Tout le monde peut voir une carte spécifique
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Utilisateur authentifié peut créer une carte
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Card $card): bool
    {
        // Admin ou propriétaire peut modifier
        return $user->role === 'admin' || $user->id === $card->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Card $card): bool
    {
        // Admin ou propriétaire peut supprimer
        return $user->role === 'admin' || $user->id === $card->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Card $card): bool
    {
        // Admin ou propriétaire peut restaurer
        return $user->role === 'admin' || $user->id === $card->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Card $card): bool
    {
        // Seul admin peut supprimer définitivement
        return $user->role === 'admin';
    }
}
