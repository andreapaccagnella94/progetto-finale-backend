<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// importo i Faker
use Faker\Generator as Faker;

class GamesMilanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $milan = Team::where("nome", "AC Milan")->first();
        $opponents = Team::where("id", "!=", $milan->id)->get();

        for ($i = 0; $i < 10; $i++) {
            $opponent = $opponents->random();
            $home = $faker->boolean() ? $milan : $opponent;
            $away = $home->id === $milan->id ? $opponent : $milan;

            $newGame = new Game();

            $newGame->data = $faker->dateTimeBetween("-6 months", "now");
            $newGame->competizione = "Serie A";
            $newGame->squadra_casa_id = $home->id;
            $newGame->squadra_trasferta_id = $away->id;
            $newGame->gol_casa = $faker->numberBetween(0, 4);
            $newGame->gol_trasferta = $faker->numberBetween(0, 4);

            $newGame->save();
        }
    }
}
