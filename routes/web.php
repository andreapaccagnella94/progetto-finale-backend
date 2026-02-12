<?php

use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// rotte CRUD per la tabella teams (usando resource)
Route::resource("teams", TeamController::class)
    ->middleware(['auth', 'verified']);

// rotte CRUD per la tabella players (usando resource)
Route::resource("players", PlayerController::class)
    ->middleware(['auth', 'verified']);


require __DIR__ . '/auth.php';
