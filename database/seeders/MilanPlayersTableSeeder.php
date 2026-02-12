<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MilanPlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $milan = Team::where("nome", "Milan")->first();
        $milan_players = config("milan_players");

        foreach ($milan_players as $player) {

            $newPlayer = new Player();

            $newPlayer->nome = $player["nome"];
            $newPlayer->cognome = $player["cognome"];
            $newPlayer->ruolo = $player["ruolo"];
            $newPlayer->numero_maglia = $player["numero_maglia"];
            $newPlayer->eta = $player["eta"];
            $newPlayer->squadra_id = $milan["id"];

            $newPlayer->save();
        }
    }
}
