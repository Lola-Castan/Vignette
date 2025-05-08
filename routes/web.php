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

// Routes d'administration des thèmes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/theme/settings', [ThemeSettingsController::class, 'index'])->name('theme.settings');
    Route::post('/theme/settings', [ThemeSettingsController::class, 'update'])->name('theme.update');
});
