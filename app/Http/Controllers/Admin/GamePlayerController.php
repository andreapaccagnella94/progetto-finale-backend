<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Player;
use Illuminate\Http\Request;

class GamePlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $giocatore_id = $request->get('giocatore_id');
        $partita_id = $request->get('partita_id');

        $giocatori = Player::with('team')->orderBy('cognome')->get(); // con la funzione with pesco direttamente il metodo team all'interno del modello Player EAGER LOADING N+1
        $partite = Game::with(['teamHome', 'teamAway'])->orderBy('data', 'desc')->get();

        return view("game_player.create", compact("giocatori", "partite", "giocatore_id", "partita_id"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // Recupera i dati del giocatore e della partita
        $giocatore = Player::find($data["giocatore_id"]);
        $partita = Game::find($data["partita_id"]);

        // Controllo se il giocatore deve appartenere ad almeno una delle due squadre della partita
        if (
            $giocatore->squadra_id != $partita->squadra_casa_id &&
            $giocatore->squadra_id != $partita->squadra_trasferta_id
        ) {
            return redirect()->back()
                ->with('error', 'Il giocatore selezionato non appartiene a nessuna delle squadre di questa partita!') // crea una sessione con questo messaggio di "error" con ->with
                ->withInput(); // recupero i campi del form old("name_che_voglio_recuperare")
        }


        $newGamePlayer = new GamePlayer();

        $newGamePlayer->game_id = $data["partita_id"];
        $newGamePlayer->player_id = $data["giocatore_id"];
        $newGamePlayer->titolare = false;
        $newGamePlayer->minuti_giocati = 0;
        $newGamePlayer->gol_segnati = 0;
        $newGamePlayer->assist = 0;
        $newGamePlayer->cartellini_gialli = 0;
        $newGamePlayer->cartellini_rossi = 0;

        $newGamePlayer->save();

        return redirect()->route("players.show", $data["giocatore_id"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GamePlayer $game_player)
    {
        $partecipazione = $game_player;
        return view("game_player.edit", compact("partecipazione"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GamePlayer $game_player)
    {
        $data = $request->all();

        $game_player->titolare = $data["titolare"];
        $game_player->minuti_giocati = $data["minuti_giocati"];
        $game_player->gol_segnati = $data["gol_segnati"];
        $game_player->assist = $data["assist"];
        $game_player->cartellini_gialli = $data["cartellini_gialli"];
        $game_player->cartellini_rossi = $data["cartellini_rossi"];

        $game_player->update();

        return redirect()->route("players.show", $game_player->player_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GamePlayer $game_player)
    {
        $game_player->delete();

        return redirect()->route("players.show", $game_player->player_id);
    }
}
