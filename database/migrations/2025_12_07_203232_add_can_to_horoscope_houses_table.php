<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('horoscope_houses', function (Blueprint $table) {
            $table->string('can', 10)->nullable()->after('label'); // Can của cung (Giáp, Ất...)
        });
    }

    public function down(): void
    {
        Schema::table('horoscope_houses', function (Blueprint $table) {
            $table->dropColumn('can');
        });
    }
};