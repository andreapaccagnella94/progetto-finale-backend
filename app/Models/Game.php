<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    // questa è la tabella secondaria/dipendente rispetto ai team per la squadra in casa
    public function teamHome()
    {
        return $this->belongsTo(Team::class, "squadra_casa_id");
    }

    // questa è la tabella secondaria/dipendente rispetto ai team per la squadra in trasferta
    public function teamAway()
    {
        return $this->belongsTo(Team::class, "squadra_trasferta_id");
    }

    // questa è un many to many rispetto ai giocatori (Players)
    public function players()
    {
        return $this->belongsToMany(Player::class)
            ->withPivot("titolare", "minuti_giocati", "gol_segnati", "assist", "cartellini_gialli", "cartellini_rossi"); // recuperare le colonne dalla tabella pivot
    }
}
