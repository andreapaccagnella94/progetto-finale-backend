<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// importo i Faker
use Faker\Generator as Faker;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $squadre = Team::all();
        $milan = Team::where("nome", "AC Milan")->first();

        $ruoli = ["Portiere", "Difensore", "Centrocampista", "Attaccante"];

        foreach ($squadre as $squadra) {

            $team_id = $squadra["id"];
            if ($team_id != $milan["id"]) {
                for ($i = 0; $i < 25; $i++) {
                    $newPlayer = new Player();

                    $newPlayer->nome = $faker->firstNameMale();
                    $newPlayer->cognome = $faker->lastName();
                    $newPlayer->ruolo = $faker->randomElement($ruoli);
                    $newPlayer->numero_maglia = $faker->numberBetween(1, 99);
                    $newPlayer->eta = $faker->numberBetween(18, 36);
                    $newPlayer->squadra_id = $team_id;

                    $newPlayer->save();
                }
            }
        }
    }
}
