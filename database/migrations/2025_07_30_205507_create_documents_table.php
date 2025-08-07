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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_fraction_id')->constrained('area_fractions')->onDelete('cascade');
            $table->enum('status', ['borrador', 'en_revision', 'revisado', 'rechazado', 'validado', 'publicado'])->default('borrador');
            $table->string('name');
            $table->string('original_name');
            $table->string('file_path');
            $table->unsignedTinyInteger('month'); // 1-12
            $table->unsignedTinyInteger('quarter'); // 1-4
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
