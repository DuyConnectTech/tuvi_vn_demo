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
        Schema::create('star_energy_levels', function (Blueprint $table) {
            $table->id();
            $table->string('star_slug', 100);
            $table->foreign('star_slug')->references('slug')->on('stars')->cascadeOnDelete();
            
            $table->string('branch_code', 20); // ty, suu, dan...
            // M: Miếu, V: Vượng, D: Đắc, B: Bình, H: Hãm
            $table->string('energy_level', 5); 
            
            $table->unique(['star_slug', 'branch_code']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('star_energy_levels');
    }
};