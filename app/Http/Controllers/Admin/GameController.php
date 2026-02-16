<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partite = Game::all();

        return view("games.index", compact("partite"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $squadre = Team::all();
        $allert = false;
        return view("games.create", compact("squadre", "allert"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $squadre = Team::all();


        if ($data["squadra_casa_id"] === $data["squadra_trasferta_id"]) {
            $allert = true;
            return view("games.create", compact("squadre", "allert"));
        }

        $newGame = new Game();

        $newGame->data = $data["data"];
        $newGame->competizione = $data["competizione"];
        $newGame->squadra_casa_id = $data["squadra_casa_id"];
        $newGame->squadra_trasferta_id = $data["squadra_trasferta_id"];
        $newGame->gol_casa = $data["gol_casa"];
        $newGame->gol_trasferta = $data["gol_trasferta"];

        $newGame->save();

        return redirect()->route("games.show", $newGame);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        $partita = $game;
        return view("games.show", compact("partita"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        $partita = $game;
        $squadre = Team::all();
        $allert = false;

        return view("games.edit", compact("partita", "squadre", "allert"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $partita = $game;
        $data = $request->all();
        $squadre = Team::all();

        if ($data["squadra_casa_id"] === $data["squadra_trasferta_id"]) {
            $allert = true;
            return view("games.edit", compact("partita", "squadre", "allert"));
        }

        $partita->data = $data["data"];
        $partita->competizione = $data["competizione"];
        $partita->squadra_casa_id = $data["squadra_casa_id"];
        $partita->squadra_trasferta_id = $data["squadra_trasferta_id"];
        $partita->gol_casa = $data["gol_casa"];
        $partita->gol_trasferta = $data["gol_trasferta"];

        $partita->save();

        return redirect()->route("games.show", $partita);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->route("games.index");
    }
}
