<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // prendo tutte le squadre
        $giocatori = Player::with("team")->get();

        return response()->json([
            "success" => true,
            "data" => $giocatori
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        $player->load("team", "games");

        return response()->json([
            "sucess" => true,
            "data" => $player
        ]);
    }
}
