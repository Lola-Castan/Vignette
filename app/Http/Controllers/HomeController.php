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
        $this->middleware('auth')->except('index');
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
        $magicNumber = $request->query('magic_number');
        $query = Card::with(['cardSize', 'categories', 'user']);

        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        if ($magicNumber) {
            $query->whereHas('user', function ($q) use ($magicNumber) {
                $q->where('magic_number', $magicNumber);
            });
        }

        $cards = $query->get();

        return view('home', compact('cards', 'categories', 'categoryId', 'magicNumber'));
    }
}
