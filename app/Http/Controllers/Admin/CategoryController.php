<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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
     * Affiche la liste des catégories
     */
    public function list()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.categories.list', compact('categories'));
    }

    /**
     * Affiche le formulaire de création d'une catégorie
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Enregistre une nouvelle catégorie
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'enabled' => 'sometimes|boolean'
        ]);
        
        // Définir enabled à true par défaut si non fourni
        if (!isset($validatedData['enabled'])) {
            $validatedData['enabled'] = true;
        }
        
        Category::create($validatedData);
        
        return redirect()->route('admin.categories.list')
            ->with('success', 'La catégorie a été créée avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'une catégorie
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Met à jour une catégorie
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'enabled' => 'sometimes|boolean'
        ]);
        
        // Gérer la case à cocher enabled
        $validatedData['enabled'] = $request->has('enabled');
        
        $category->update($validatedData);
        
        return redirect()->route('admin.categories.list')
            ->with('success', 'La catégorie a été mise à jour avec succès.');
    }

    /**
     * Supprime une catégorie
     */
    public function destroy(Category $category)
    {
        // Vérifier si la catégorie est utilisée par des cards
        if ($category->cards()->count() > 0) {
            return redirect()->route('admin.categories.list')
                ->with('error', 'Cette catégorie ne peut pas être supprimée car elle est utilisée par des cartes.');
        }
        
        $category->delete();
        
        return redirect()->route('admin.categories.list')
            ->with('success', 'La catégorie a été supprimée avec succès.');
    }
}