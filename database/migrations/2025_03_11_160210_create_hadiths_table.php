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
        Schema::create('hadiths', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('texte_arabe'); // Texte original du hadith
            $table->text('traduction_haoussa')->nullable();
            $table->text('traduction_zarma')->nullable();
            $table->string('image')->nullable(); // Chemin de l'image associée
            $table->string('audio_haoussa')->nullable();
            $table->string('audio_zarma')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hadiths');
    }
};
