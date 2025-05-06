<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $categoryId = $request->query('category');
        $query = Card::with(['cardSize', 'categories']);

        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        $cards = $query->get();

        return view('home', compact('cards', 'categories', 'categoryId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCardRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['card_size_id'] = 1;
        if (!isset($data['description'])) {
            $data['description'] = '';
        }

        // Si une vidéo est uploadée, on ignore image et music
        if ($request->hasFile('video')) {
            $data['video'] = "storage/" . $request->file('video')->store('videos', 'public');
            $data['image'] = null;
            $data['music'] = null;
        } else {
            // Image
            if ($request->hasFile('image')) {
                $data['image'] = "storage/" . $request->file('image')->store('images', 'public');
            }
            // Son
            if ($request->hasFile('music')) {
                $data['music'] = "storage/" . $request->file('music')->store('sounds', 'public');
            }
            $data['video'] = null;
        }

        Card::create($data);
        return redirect()->route('cards_list')->with('success', 'Carte créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return redirect()->route('cards_list', ['card' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Card $card)
    {
        return view('cards.edit', compact('card'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCardRequest $request, Card $card)
    {
        $card->update($request->validated());
        return redirect()->route('cards_edit', $card->id)->with('success', 'Carte modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card)
    {
        $card->delete();
        return redirect()->route('cards_list')->with('success', 'Carte supprimée avec succès !');
    }
}
