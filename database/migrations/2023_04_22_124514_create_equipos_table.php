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
        Schema::create('equipos', function (Blueprint $table) {
            $table->engine="InNoDB";
            $table->id();
            $table->string('NombreEquipo');
            $table->string('FotoEquipo');
            $table->integer('PartidosGanados')->default(0);
            $table->integer('PartidosPerdidos')->default(0);
            $table->integer('PartidosEmpatados')->default(0);
            $table->integer('PuntosTotales')->default(0);
            $table->integer('PartidosJugados')->default(0);
            $table->integer('Capitan')->references('id')->on('usuarios');
            $table->bigInteger('DeporteId')->unsigned();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->foreign('DeporteId')->references('id')->on('deportes')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
