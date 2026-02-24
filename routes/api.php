<?php

use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */

// rotte api per le squadre
Route::get("teams", [TeamController::class, "index"]);
Route::get("teams/{team}", [TeamController::class, "show"]);

// rotte api per i giocatori
Route::get("players", [PlayerController::class, "index"]);
Route::get("players/{player}", [PlayerController::class, "show"]);

// rotte api per i giocatori
Route::get("games", [GameController::class, "index"]);
Route::get("games/{game}", [GameController::class, "show"]);
