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
        Schema::create('horoscopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('slug')->unique(); // Added unique constraint for slug based on DBML but it says varchar(255) [not null] in DBML, unique is good practice for slug
            $table->string('name')->nullable();
            $table->string('gender', 10)->nullable(); // male / female
            
            $table->dateTime('birth_gregorian');
            $table->string('timezone', 64)->default('Asia/Ho_Chi_Minh');
            
            // Lunar
            $table->integer('birth_lunar_year')->nullable();
            $table->integer('birth_lunar_month')->nullable();
            $table->integer('birth_lunar_day')->nullable();
            $table->boolean('birth_lunar_is_leap')->default(false);
            
            // Can Chi
            $table->string('can_chi_year', 50)->nullable();
            $table->string('can_chi_month', 50)->nullable();
            $table->string('can_chi_day', 50)->nullable();
            $table->string('can_chi_hour', 50)->nullable();
            
            // Menh/Cuc...
            $table->string('nap_am', 100)->nullable();
            $table->string('am_duong', 10)->nullable();
            $table->string('cuc', 50)->nullable();
            $table->string('can_luong', 50)->nullable();
            
            // Source
            $table->unsignedBigInteger('external_chart_id')->nullable();
            $table->string('source_url', 511)->nullable();
            $table->integer('view_year')->nullable();
            $table->integer('view_month')->nullable();
            $table->longText('raw_html')->nullable();
            $table->json('raw_input')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horoscopes');
    }
};