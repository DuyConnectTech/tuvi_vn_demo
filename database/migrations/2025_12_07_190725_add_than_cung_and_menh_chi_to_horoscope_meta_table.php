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
        Schema::table('horoscope_meta', function (Blueprint $table) {
            $table->string('than_cung_code', 50)->nullable()->after('lai_nhan_cung');
            $table->integer('menh_chi_index')->nullable()->after('than_cung_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('horoscope_meta', function (Blueprint $table) {
            $table->dropColumn(['than_cung_code', 'menh_chi_index']);
        });
    }
};