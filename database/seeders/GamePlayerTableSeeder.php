<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// importo i Faker
use Faker\Generator as Faker;

class GamePlayerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $milan = Team::where("nome", "AC Milan")->first();
        // partite in cui il milan è in casa
        $game_milan_home = Game::where("squadra_casa_id", $milan->id)->get();
        // partite in cui il milan è in trasferta
        $game_milan_away = Game::where("squadra_trasferta_id", $milan->id)->get();

        // per ogni partita del milan in casa generiamo o giocatori
        foreach ($game_milan_home as $game) {
            // giocaotori della squadra casa
            $players_home = Player::where("squadra_id", $game->squadra_casa_id)->get();
            // giocaotori della squadra trasferta
            $players_away = Player::where("squadra_id", $game->squadra_trasferta_id)->get();
        }
    }


    // funzione interna per creare giocatori specifici 11 titolari e 5 riserve
    private function generaGiocatori($faker, $giocatori, $partita_id, $isTeamHome)
    {
        // verifico che almeno ogni squadra abbia 16 giocatori
        if ($giocatori->count() < 16) {
            echo "La squadra non è completa per generare un match completo";
        }

        // prendo 11 titolari
        $titolari = $giocatori->take(11);
        // prendo 5 riserve
        $riserve = $giocatori->skip(11)->take(5);

        // inserisco i titolari 
        foreach ($titolari as $giocatore) {
            $statistiche = $this->generaStatistiche($faker, true, $giocatore);
        }
    }


    private function generaStatistiche($faker, $titolare, $giocatore)
    {
        // Minuti giocati
        $minutiGiocati = $titolare ?
            $faker->numberBetween(45, 90) :
            $faker->numberBetween(0, 45);

        // Gol segnati (più probabili per attaccanti e centrocampisti)
        $golSegnati = 0;
        if ($minutiGiocati > 0) {
            // Portieri segnano molto raramente
            if ($giocatore->ruolo === 'Portiere') {
                $golSegnati = $faker->boolean(1) ? $faker->numberBetween(1, 1) : 0;
            }
            // Difensori segnano raramente
            elseif ($giocatore->ruolo === 'Difensore') {
                $golSegnati = $faker->boolean(10) ? $faker->numberBetween(1, 2) : 0;
            }
            // Centrocampisti segnano occasionalmente
            elseif ($giocatore->ruolo === 'Centrocampista') {
                $golSegnati = $faker->boolean(20) ? $faker->numberBetween(1, 2) : 0;
            }
            // Attaccanti segnano più frequentemente
            else {
                $golSegnati = $faker->boolean(30) ? $faker->numberBetween(1, 3) : 0;
            }
        }

        // Assist (più probabili per centrocampisti)
        $assist = 0;
        if ($minutiGiocati > 0) {
            if ($giocatore->ruolo === 'Centrocampista') {
                $assist = $faker->boolean(25) ? $faker->numberBetween(1, 2) : 0;
            } else {
                $assist = $faker->boolean(10) ? $faker->numberBetween(1, 1) : 0;
            }
        }

        // Cartellini
        $cartelliniGialli = 0;
        $cartelliniRossi = 0;

        // Probabilità di cartellino giallo
        if ($faker->boolean(15)) {
            $cartelliniGialli = $faker->numberBetween(1, 2);

            // Se ha 2 gialli, ha un rosso indiretto
            if ($cartelliniGialli == 2) {
                $cartelliniRossi = 1;
            }
            // Probabilità diretta di rosso
            elseif ($faker->boolean(5)) {
                $cartelliniRossi = 1;
                $cartelliniGialli = 0; // Nessun giallo se diretto
            }
        }
        return [
            'minuti' => $minutiGiocati,
            'gol' => $golSegnati,
            'assist' => $assist,
            'gialli' => $cartelliniGialli,
            'rossi' => $cartelliniRossi
        ];
    }
}
