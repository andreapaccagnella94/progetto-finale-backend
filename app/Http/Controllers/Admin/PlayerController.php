<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        // verifico caricamento logo
        if (array_key_exists("foto", $data)) {
            // carico foto
            $img_url = Storage::putFile("giocatori", $data["foto"]);
            $newPlayer->foto = $img_url;
        }

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
        // solo le partite in cui è presente la squadra del giocatore
        $partite = Game::where("squadra_casa_id", $giocatore->squadra_id)
            ->orWhere("squadra_trasferta_id", $giocatore->squadra_id)
            ->get();

        return view("players.edit", compact("giocatore", "ruoli", "squadre", "partite"));
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

        // verifico caricamento foto
        if (array_key_exists("foto", $data)) {
            // elimino foto "vecchia" se presente
            if ($giocatore->foto) {
                Storage::delete($giocatore->foto);
            }

            // carico foto
            $img_url = Storage::putFile("giocatori", $data["foto"]);

            // aggiorno db
            $giocatore->foto = $img_url;
        }

        $giocatore->update();

        // sincronizzare i dati con la tabella pivot
        if ($request->has("games")) {
            $giocatore->games()->sync($data["games"]);
        } else {
            $giocatore->games()->detach();
        }

        return redirect()->route("players.show", $giocatore);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        // verifico se il giocatore ha una foto e nel caso elimino il file dal db
        if ($player->logo) {
            Storage::delete($player->logo);
        }

        // verifico se il mio giocatore ha partite collegate e elimino dalla pivot
        if ($player->has("games")) {
            $player->games()->detach();
        }

        // elimino il giocatore
        $player->delete();

        return redirect()->route("players.index");
    }
}
