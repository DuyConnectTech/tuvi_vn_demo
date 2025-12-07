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
        Schema::create('horoscope_meta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('horoscope_id')->constrained('horoscopes')->cascadeOnDelete();
            $table->string('view_year_can_chi', 50)->nullable();
            $table->integer('age_at_view')->nullable();
            $table->string('chu_menh', 191)->nullable();
            $table->string('chu_than', 191)->nullable();
            $table->string('lai_nhan_cung', 50)->nullable();
            $table->integer('template')->nullable();
            $table->integer('theme')->nullable();
            $table->json('extra')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horoscope_meta');
    }
};