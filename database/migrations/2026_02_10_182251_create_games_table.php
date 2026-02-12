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
        Schema::create('games', function (Blueprint $table) {
            $table->id();

            $table->date("data");
            $table->string("competizione");
            $table->foreignId("squadra_casa_id")->constrained("teams")->onDelete("cascade"); // se la squadra viene eliminata elimina anche la riga della partitia in cui c'è
            $table->foreignId("squadra_trasferta_id")->constrained("teams")->onDelete("cascade");
            $table->integer("gol_casa");
            $table->integer("gol_trasferta");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
