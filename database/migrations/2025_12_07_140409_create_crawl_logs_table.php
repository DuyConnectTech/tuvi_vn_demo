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
        Schema::create('crawl_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('horoscope_id')->nullable();
            $table->string('source_url', 511)->nullable();
            $table->integer('status_code')->nullable();
            $table->integer('response_length')->nullable();
            $table->dateTime('crawled_at')->nullable();
            $table->longText('raw_html')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crawl_logs');
    }
};