<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    // questa è la tabella principale/indipendente rispetto ai giocatori
    public function players()
    {
        return $this->hasMany(Player::class);
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
