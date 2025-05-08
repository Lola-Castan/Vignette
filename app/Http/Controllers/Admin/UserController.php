<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
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
     * Affiche la liste des utilisateurs
     */
    public function list()
    {
        $users = User::orderBy('name')->get();
        return view('admin.users.list', compact('users'));
    }

    /**
     * Affiche le formulaire de création d'un utilisateur
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Enregistre un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'magic_number' => 'nullable|integer'
        ]);
        
        // Force le rôle à 'user' car l'admin est unique et prédéfini
        $validatedData['role'] = 'user';
        
        // Hash du mot de passe
        $validatedData['password'] = Hash::make($validatedData['password']);
        
        User::create($validatedData);
        
        return redirect()->route('admin.users.list')
            ->with('success', 'L\'utilisateur a été créé avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'un utilisateur
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'magic_number' => 'nullable|integer'
        ]);
        
        // Ne mettre à jour le mot de passe que s'il est fourni
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
        
        // Empêcher la modification du rôle de n'importe quel utilisateur
        // car l'admin est unique et prédéfini
        if (isset($validatedData['role'])) {
            unset($validatedData['role']);
        }
        
        $user->update($validatedData);
        
        return redirect()->route('admin.users.list')
            ->with('success', 'L\'utilisateur a été mis à jour avec succès.');
    }

    /**
     * Supprime un utilisateur
     */
    public function destroy(User $user)
    {
        // Empêcher la suppression de son propre compte
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.list')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
        
        // Empêcher la suppression de l'administrateur
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.list')
                ->with('error', 'Impossible de supprimer l\'administrateur.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.list')
            ->with('success', 'L\'utilisateur a été supprimé avec succès.');
    }
}
