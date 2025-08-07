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
        Schema::create('area_fractions', function (Blueprint $table) {
            $table->id();
            $table->year('fiscal_year'); // Año en el que se aplica la fracción
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->foreignId('fraction_id')->constrained('fractions')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['area_id', 'fraction_id', 'fiscal_year']); // Evitar duplicidad
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_fractions');
    }
};
