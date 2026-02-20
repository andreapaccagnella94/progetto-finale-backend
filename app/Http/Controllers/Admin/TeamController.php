<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // prendo le squadre in ordine alfabetico
        $squadre = Team::orderBy("nome")->get();

        return view("teams.index", compact("squadre"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("teams.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $newTeam = new Team();

        $newTeam->nome = $data["nome"];
        $newTeam->citta = $data["citta"];
        $newTeam->stadio = $data["stadio"];
        $newTeam->anno_fondazione = $data["anno_fondazione"];

        // verifico caricamento logo
        if (array_key_exists("logo", $data)) {
            // carico logo
            $img_url = Storage::putFile("squadre", $data["logo"]);
            $newTeam->logo = $img_url;
        }

        $newTeam->save();

        return redirect()->route("teams.show", $newTeam);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $squadra = $team;
        return view("teams.show", compact("squadra"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        $squadra = $team;
        return view("teams.edit", compact("squadra"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $squadra = $team;
        $data = $request->all();

        $squadra->nome = $data["nome"];
        $squadra->citta = $data["citta"];
        $squadra->stadio = $data["stadio"];
        $squadra->anno_fondazione = $data["anno_fondazione"];

        // verifico caricamento logo
        if (array_key_exists("logo", $data)) {
            // elimino logo "vecchio" se presente
            if ($squadra->logo) {
                Storage::delete($squadra->logo);
            }

            // carico logo
            $img_url = Storage::putFile("squadre", $data["logo"]);

            // aggiorno db
            $squadra->logo = $img_url;
        }

        $squadra->update();

        return redirect()->route("teams.show", $squadra);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $squadra = $team;

        $squadra->delete();

        return redirect()->route("teams.index");
    }
}
