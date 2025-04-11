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
        Schema::create('erudits', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Nom de l’érudit
            $table->string('nationalite')->nullable();
            $table->text('biographie')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('erudits');
    }
};
