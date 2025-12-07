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
        Schema::create('horoscope_house_stars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('horoscope_house_id')->constrained('horoscope_houses')->cascadeOnDelete();
            $table->foreignId('star_id')->constrained('stars')->cascadeOnDelete();

            $table->string('status', 10)->nullable(); // Mieu / Vuong / Dac / Binh / Ham
            $table->boolean('is_transit')->default(false); // 0: sao goc, 1: sao luu
            $table->string('source_text', 255)->nullable();
            $table->integer('order')->nullable();
            $table->json('extra')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horoscope_house_stars');
    }
};