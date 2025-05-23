<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ThemeSettingsController;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// CARDS ROUTES
Route::get('/cards', [App\Http\Controllers\CardController::class, 'index'])->name('cards_list');
Route::get('/cards/create', [App\Http\Controllers\CardController::class, 'create'])->name('cards_create');
Route::post('/cards/create', [App\Http\Controllers\CardController::class, 'store'])->name('cards_store');
Route::get('/cards/{card}', [App\Http\Controllers\CardController::class, 'show'])->name('cards_show');
Route::get('/cards/{card}/edit', [App\Http\Controllers\CardController::class, 'edit'])->name('cards_edit');
Route::put('/cards/{card}', [App\Http\Controllers\CardController::class, 'update'])->name('cards_update');
Route::delete('/cards/{card}', [App\Http\Controllers\CardController::class, 'destroy'])->name('cards_delete');

// Routes d'administration des thèmes et des catégories
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Routes pour le theme
    Route::get('/theme/settings', [ThemeSettingsController::class, 'index'])->name('theme.settings');
    Route::post('/theme/settings', [ThemeSettingsController::class, 'update'])->name('theme.update');
    
    // Routes pour les catégories
    Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'list'])->name('categories.list');
    Route::get('/categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Routes pour les utilisateurs
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'list'])->name('users.list');
    Route::get('/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    
    // Routes pour les cartes (admin)
    Route::get('/cards', [App\Http\Controllers\Admin\CardController::class, 'list'])->name('cards.list');
    Route::get('/cards/{card}/edit', [App\Http\Controllers\Admin\CardController::class, 'edit'])->name('cards.edit');
    Route::put('/cards/{card}', [App\Http\Controllers\Admin\CardController::class, 'update'])->name('cards.update');
    Route::delete('/cards/{card}', [App\Http\Controllers\Admin\CardController::class, 'destroy'])->name('cards.destroy');
});
