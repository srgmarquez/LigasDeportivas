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
        Schema::create('solicituds', function (Blueprint $table) {
            $table->engine="InNoDB";
            $table->id();
            $table->string('NombreEquipo');
            $table->string('FotoEquipo');
            $table->integer('Deporte');
            $table->integer('EstadoSolicitud')->default(0);
            $table->string('ResolucionSolicitud')->default("Pendiente");
            $table->bigInteger('UsuarioId')->unsigned();
            $table->foreign('UsuarioId')->references('id')->on('usuarios')->onDelete("cascade");
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicituds');
    }
};
