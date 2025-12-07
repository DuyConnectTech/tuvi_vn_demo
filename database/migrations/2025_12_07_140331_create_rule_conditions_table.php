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
        Schema::create('rule_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rule_id')->constrained('rules')->cascadeOnDelete();
            
            $table->string('type', 50); // has_star, has_any_star, has_star_pair, can_chi_year...
            $table->string('field', 100)->nullable();
            $table->string('operator', 20)->nullable();
            $table->json('value');
            $table->integer('or_group')->nullable();
            $table->string('house_code', 50)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rule_conditions');
    }
};