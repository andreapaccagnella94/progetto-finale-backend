<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;



class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $giocatori_query = Player::orderBy("ruolo"); // usato paginate e aggiunto nel file AppServiceProvider.php le rige per usare Bootstrap come stile

        if ($request->has('search')) {
            $search = $request->get('search');
            $giocatori_query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                    ->orWhere('cognome', 'like', "%{$search}%")
                    ->orWhere('ruolo', 'like', "%{$search}%");
            });
        }

        $giocatori = $giocatori_query->paginate(12);

        return view("players.index", compact("giocatori"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ruoli = ["Portiere", "Difensore", "Centrocampista", "Attaccante"];
        $squadre = Team::all();

        return view("players.create", compact("ruoli", "squadre"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $newPlayer = new Player();

        $newPlayer->nome = $data["nome"];
        $newPlayer->cognome = $data["cognome"];
        $newPlayer->ruolo = $data["ruolo"];
        $newPlayer->numero_maglia = $data["numero_maglia"];
        $newPlayer->eta = $data["eta"];
        $newPlayer->squadra_id = $data["squadra_id"];

        $newPlayer->save();

        return redirect()->route("players.show", $newPlayer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        $giocatore = $player;
        return view("players.show", compact("giocatore"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        $giocatore = $player;
        $ruoli = ["Portiere", "Difensore", "Centrocampista", "Attaccante"];
        $squadre = Team::all();

        return view("players.edit", compact("giocatore", "ruoli", "squadre"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        $giocatore = $player;
        $data = $request->all();

        $giocatore->nome = $data["nome"];
        $giocatore->cognome = $data["cognome"];
        $giocatore->ruolo = $data["ruolo"];
        $giocatore->numero_maglia = $data["numero_maglia"];
        $giocatore->eta = $data["eta"];
        $giocatore->squadra_id = $data["squadra_id"];

        $giocatore->update();

        return redirect()->route("players.show", $giocatore);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        $player->delete();

        return redirect()->route("players.index");
    }
}
