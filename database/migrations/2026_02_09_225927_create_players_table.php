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
        Schema::create('players', function (Blueprint $table) {
            $table->id();

            $table->string("nome");
            $table->string("cognome");
            $table->string("ruolo");
            $table->integer("numero_maglia");
            $table->integer("eta");
            $table->foreignId("squadra_id")->nullable()->constrained("teams")->onDelete("set null"); // se la squadra viene eliminata diventa nullo il campo del giocatore
            $table->text("foto")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
