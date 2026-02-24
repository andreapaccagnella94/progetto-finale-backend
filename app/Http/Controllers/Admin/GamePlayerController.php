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
        $partita = Game::find($partita_id);
        $giocatore = Player::find($giocatore_id);

        // faccio vedere solo i giocatori delle squadre della partita
        if ($partita_id) {
            $giocatori = Player::with('team')->where("squadra_id", $partita->teamHome->id)->orWhere("squadra_id", $partita->teamAway->id)->orderBy('squadra_id')->get(); // con la funzione with pesco direttamente il metodo team all'interno del modello Player EAGER LOADING N+1
        } else {
            $giocatori = Player::with('team')->orderBy('cognome')->get();
        }

        // faccio vedere solo le partite in cui è presente il giocatore
        if ($giocatore_id) {
            $partite = Game::with(['teamHome', 'teamAway'])->where("squadra_casa_id", $giocatore->team->id)->orWhere("squadra_trasferta_id", $giocatore->team->id)->orderBy('data', 'desc')->get();
        } else {
            $partite = Game::with(['teamHome', 'teamAway'])->orderBy('data', 'desc')->get();
        }

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

        // Controllo unicità: non permettere duplicate (stessa partita e stesso giocatore)
        $exists = GamePlayer::where('game_id', $data['partita_id'])
            ->where('player_id', $data['giocatore_id'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Questo giocatore è già registrato per la partita selezionata.')
                ->withInput();
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

        return redirect()->route("games.show", $data["partita_id"]);
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

        // verifico se è titolare
        if (array_key_exists("titolare", $data)) {
            $game_player->titolare = $data["titolare"];
        } else {
            $game_player->titolare = 0;
        }
        $game_player->minuti_giocati = $data["minuti_giocati"];
        $game_player->gol_segnati = $data["gol_segnati"];
        $game_player->assist = $data["assist"];
        $game_player->cartellini_gialli = $data["cartellini_gialli"];
        $game_player->cartellini_rossi = $data["cartellini_rossi"];

        $game_player->update();

        return redirect()->route("games.show", $game_player->game_id);
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
