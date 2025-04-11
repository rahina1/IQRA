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
        Schema::create('traductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verset_id')->constrained()->onDelete('cascade');
            $table->foreignId('erudit_id')->constrained()->onDelete('cascade');
            $table->string('langue', 50); // ex: 'francais', 'haoussa', 'zarma'
            $table->text('texte_traduction')->nullable();
            $table->string('audio_path')->nullable();
            $table->timestamps();

            // Index composite pour éviter les doublons
            $table->unique(['verset_id', 'erudit_id', 'langue']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traductions');
    }
};
