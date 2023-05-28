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
        Schema::create('partidos', function (Blueprint $table) {
            $table->engine="InNoDB";
            $table->id();
            $table->unsignedBigInteger('EquipoLocal');
            $table->unsignedBigInteger('EquipoVisitante');
            $table->foreign('EquipoLocal')->references('id')->on('equipos')->onDelete("cascade");
            $table->foreign('EquipoVisitante')->references('id')->on('equipos')->onDelete("cascade");
            $table->integer('GolesEquipoLocal')->default(0);
            $table->integer('GolesEquipoVisitante')->default(0);
            $table->date('FechaPartido');
            $table->string('Estado')->default("Pendiente");
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidos');
    }
};
