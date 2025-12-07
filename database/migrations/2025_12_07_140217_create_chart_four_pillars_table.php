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
        Schema::create('chart_four_pillars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('horoscope_id')->constrained('horoscopes')->cascadeOnDelete();
            $table->string('pillar_type', 10); // year|month|day|hour
            $table->string('heavenly_stem', 10)->nullable();
            $table->string('earthly_branch', 10)->nullable();
            $table->string('element', 20)->nullable();
            $table->json('hidden_stems')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chart_four_pillars');
    }
};