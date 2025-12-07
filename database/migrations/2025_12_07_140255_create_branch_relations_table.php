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
        Schema::create('branch_relations', function (Blueprint $table) {
            $table->id();
            $table->string('from_house_code', 50);
            $table->string('to_house_code', 50);
            $table->string('relation_type', 50); // tam_hop|xung|nhihop|chieu|luc_hop|doi_chieu
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_relations');
    }
};