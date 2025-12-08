<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('horoscope_houses', function (Blueprint $table) {
            $table->string('tieu_han', 50)->nullable()->after('dai_van_start_age'); // Lưu tên năm (ví dụ: "Tỵ") nếu cung này là tiểu hạn năm Tỵ
            $table->string('nguyet_han', 50)->nullable()->after('tieu_han'); // Lưu tháng (ví dụ: "1", "7") nếu cung này là nguyệt hạn
        });
    }

    public function down(): void
    {
        Schema::table('horoscope_houses', function (Blueprint $table) {
            $table->dropColumn(['tieu_han', 'nguyet_han']);
        });
    }
};