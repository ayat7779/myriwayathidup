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
        Schema::create('pangkats', function (Blueprint $table) {
            $table->id();
            $table->string('golongan'); // e.g. "I/a", "III/c", "IV/e"
            $table->string('pangkat'); // e.g. "Juru Muda", "Penata Muda", "Pembina Utama"
            $table->integer('tingkat')->default(1); // For sorting priority
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pangkats');
    }
};
