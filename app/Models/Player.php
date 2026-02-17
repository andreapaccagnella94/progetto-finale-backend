<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    // questa è la tabella secondaria/dipendente rispetto ai team
    public function team()
    {
        return $this->belongsTo(Team::class, 'squadra_id'); // Eloquent cerca la colonna team_id nel db quindi bisogna indicare quale deve prendere se la lingua non combacia
    }

    // questa è un many to many rispetto alle partite (Games)
    public function games()
    {
        return $this->belongsToMany(Game::class)
            ->withPivot("id", "titolare", "minuti_giocati", "gol_segnati", "assist", "cartellini_gialli", "cartellini_rossi"); // recuperare le colonne dalla tabella pivot con la funzione
    }
}
