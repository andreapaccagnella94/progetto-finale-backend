<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // prendo tutte le squadre
        $squadre = Team::all();

        return response()->json([
            "success" => true,
            "data" => $squadre
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $squadra = $team;
        $squadra->load("players", "teamHome", "teamAway");

        return response()->json([
            "succes" => true,
            "data" => $squadra
        ]);
    }
}
