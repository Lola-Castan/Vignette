<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // L'accueil est accessible sans authentification
        // Décommentez la ligne ci-dessous si vous avez d'autres méthodes à protéger
        // $this->middleware('auth')->except('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
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
}
