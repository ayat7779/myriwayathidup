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
        // 1. Tanda Jasa / Penghargaan
        Schema::create('tanda_jasas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->string('nama_penghargaan'); // Nama Bintang / Satya Lencana / Penghargaan
            $table->string('tahun_perolehan')->nullable();
            $table->string('instansi_pemberi')->nullable(); // Nama Negara / Instansi
            $table->timestamps();
        });

        // 2. Pengalaman Kunjungan ke Luar Negeri
        Schema::create('kunjungan_luar_negeris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->string('negara_tujuan');
            $table->string('tujuan_kunjungan');
            $table->string('lama_kunjungan')->nullable();
            $table->string('yang_membiayai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan_luar_negeris');
        Schema::dropIfExists('tanda_jasas');
    }
};
