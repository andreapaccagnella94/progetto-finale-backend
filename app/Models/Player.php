<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    // questa è la tabella secondaria/dipendente rispetto ai team
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    // questa è un many to many rispetto alle partite (Games)
    public function games()
    {
        return $this->belongsToMany(Game::class)
            ->withPivot("titolare", "minuti_giocati", "gol_segnati", "assist", "cartellini_gialli", "cartellini_rossi"); // recuperare le colonne dalla tabella pivot con la funzione
    }
}
