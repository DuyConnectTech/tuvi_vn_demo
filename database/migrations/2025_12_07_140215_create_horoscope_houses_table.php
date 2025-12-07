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
        Schema::create('horoscope_houses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('horoscope_id')->constrained('horoscopes')->cascadeOnDelete();
            
            $table->string('code', 50); // MENH, PHU_MAU...
            $table->string('label', 100);
            $table->string('branch', 20)->nullable(); // Ty, Suu...
            $table->string('element', 20)->nullable(); // Thuy, Moc...
            $table->string('life_phase', 50)->nullable(); // Truong Sinh...
            
            $table->integer('house_order'); // 1..12
            
            // Dai van
            $table->integer('dai_van_start_age')->nullable();
            $table->integer('dai_van_end_age')->nullable();
            
            // Extra
            $table->integer('score')->nullable();
            $table->integer('lunar_month')->nullable();
            $table->json('relations')->nullable(); // xung_chieu, tam_hop...
            $table->json('extra')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horoscope_houses');
    }
};