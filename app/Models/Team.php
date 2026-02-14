<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    // questa è la tabella principale/indipendente rispetto ai giocatori
    public function players()
    {
        return $this->hasMany(Player::class, 'squadra_id'); // Eloquent cerca la colonna team_id nel db quindi bisogna indicare quale deve prendere se la lingua non combacia
    }

    // questa è la tabella principale/indipendente rispetto alle partite in casa
    public function gamesHome()
    {
        return $this->hasMany(Game::class, "squadra_casa_id");
    }

    // questa è la tabella principale/indipendente rispetto alle partite in casa
    public function gamesAway()
    {
        return $this->hasMany(Game::class, "squadra_trasferta_id");
    }
}
