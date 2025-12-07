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
        Schema::create('luc_thap_hoa_giap', function (Blueprint $table) {
            $table->id();
            $table->string('can_chi', 50)->unique(); // Giáp Tý, Ất Sửu...
            $table->string('can', 10); // Giáp, Ất...
            $table->string('chi', 10); // Tý, Sửu...
            $table->string('nap_am', 100); // Hải Trung Kim...
            $table->string('ngu_hanh', 20); // Kim, Mộc, Thủy, Hỏa, Thổ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('luc_thap_hoa_giap');
    }
};