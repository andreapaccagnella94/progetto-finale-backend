<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // prendo tutte le partite con le sue relazioni
        $partite = Game::with("teamHome", "teamAway")->get();

        return response()->json([
            "success" => true,
            "data" => $partite
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        $game->load("teamHome", "teamAway", "players");

        return response()->json([
            "success" => true,
            "data" => $game
        ]);
    }
}
