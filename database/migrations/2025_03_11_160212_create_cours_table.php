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

        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('contenu')->nullable(); // Contenu textuel du cours
            $table->string('langue'); // haoussa, zarma, arabe
            $table->string('fichier_pdf')->nullable(); // PDF du cours
            $table->string('audio')->nullable(); // Fichier MP3
            $table->string('video')->nullable(); // Fichier MP4 ou lien YouTube
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours');
    }
};
