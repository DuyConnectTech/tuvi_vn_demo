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
        Schema::create('horoscope_house_star_effects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('horoscope_house_id')->constrained('horoscope_houses')->cascadeOnDelete();
            $table->foreignId('star_id')->constrained('stars')->cascadeOnDelete();
            
            $table->string('effect_type', 50)->nullable(); // HoaLoc|HoaQuyen|HoaKhoa|HoaKy
            $table->string('target_house_code', 50)->nullable();
            $table->json('extra')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horoscope_house_star_effects');
    }
};