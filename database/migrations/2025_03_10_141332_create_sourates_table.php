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
        Schema::create('sourates', function (Blueprint $table) {
            $table->id();
            $table->integer('numero'); // Numéro de la sourate (1 à 114)
            $table->string('nom_arabe'); // Nom en arabe
            $table->string('nom_transliteration'); // Ex: "Al-Fatiha"
            $table->integer('nombre_versets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sourates');
    }
};
