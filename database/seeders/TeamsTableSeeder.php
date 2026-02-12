<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// importo i Faker
use Faker\Generator as Faker;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $squadre = config("teams_serieA");

        foreach ($squadre as $squadra) {
            $newTeam = new Team();

            $newTeam->nome = $squadra["nome"];
            $newTeam->citta = $squadra["citta"];
            $newTeam->stadio = $squadra["stadio"];
            $newTeam->anno_fondazione = $squadra["anno_fondazione"];

            $newTeam->save();
        }
    }
}
