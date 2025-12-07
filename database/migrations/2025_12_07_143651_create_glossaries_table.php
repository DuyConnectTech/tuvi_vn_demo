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
        Schema::create('glossaries', function (Blueprint $table) {
            $table->id();
            $table->string('term', 191)->unique();
            $table->string('slug', 191)->unique();
            $table->string('category', 100)->nullable(); // e.g., Thuật ngữ chung, Tên Sao, Cách Cục, Vòng Hạn
            $table->text('description')->nullable();
            $table->string('reference_url', 511)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('glossaries');
    }
};