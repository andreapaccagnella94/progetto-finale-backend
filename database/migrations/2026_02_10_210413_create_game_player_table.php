<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_player', function (Blueprint $table) {
            $table->id();

            // tabella pivot con le chiavi 
            $table->foreignId("game_id")->constrained()->onDelete("cascade");
            $table->foreignId("player_id")->constrained()->onDelete("cascade");
            // colonne aggiuntive
            $table->boolean("titolare")->default(false);
            $table->unsignedSmallInteger("minuti_giocati")->default(0);
            $table->unsignedSmallInteger("gol_segnati")->default(0);
            $table->unsignedSmallInteger("assist")->default(0);
            $table->unsignedSmallInteger("cartellini_gialli")->default(0);
            $table->unsignedSmallInteger("cartellini_rossi")->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_player');
    }
};
