<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\CardSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    /**
     * Constructeur qui vérifie que l'utilisateur est administrateur
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                abort(403, 'Accès non autorisé.');
            }
            return $next($request);
        });
    }

    /**
     * Affiche la liste des cartes avec options de gestion
     */
    public function list()
    {
        $cards = Card::with(['user', 'cardSize', 'categories'])->orderBy('created_at', 'desc')->get();
        $cardSizes = CardSize::all();
        return view('admin.cards.list', compact('cards', 'cardSizes'));
    }

    /**
     * Affiche le formulaire de modification de la taille d'une carte
     */
    public function edit(Card $card)
    {
        $cardSizes = CardSize::all();
        return view('admin.cards.edit', compact('card', 'cardSizes'));
    }

    /**
     * Met à jour la taille d'une carte
     */
    public function update(Request $request, Card $card)
    {
        $validated = $request->validate([
            'card_size_id' => 'required|exists:card_sizes,id',
        ]);
        
        $card->update($validated);
        
        return redirect()->route('admin.cards.list')
            ->with('success', 'La taille de la carte a été mise à jour avec succès.');
    }

    /**
     * Supprime une carte
     */
    public function destroy(Card $card)
    {
        $card->delete();
        
        return redirect()->route('admin.cards.list')
            ->with('success', 'La carte a été supprimée avec succès.');
    }
}
