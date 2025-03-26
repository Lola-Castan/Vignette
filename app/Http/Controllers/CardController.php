<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view('cards.index', ['cards' => Card::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Log::info('User :' . Auth::id() . ' wants to create a card');
        // return view('cards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCardRequest $request)
    {
        // Création d'une carte en récupérant les données validées et en ajoutant l'id de l'utilisateur connecté au tableau envoyé
        Card::create($request->validated() + ['user_id' => Auth::id()]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $cardId)
    {
        $card = Card::find($cardId);
        // return view('cards.show', ['card' => $cardId]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Card $cardId)
    {
        $card = Card::find($cardId);
        // return view('cards.edit', ['card' => $card]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCardRequest $request, Card $card)
    {
        $card->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card)
    {
        Card::destroy($card);
    }
}
