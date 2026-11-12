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
        // 1. Riwayat Kepangkatan & Golongan Ruang Penggajian
        Schema::create('riwayat_kepangkatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->foreignId('pangkat_id')->constrained('pangkats')->cascadeOnDelete();
            $table->date('tmt_pangkat'); // Terhitung Mulai Tanggal
            $table->decimal('gaji_pokok', 15, 2)->default(0);
            $table->string('sk_pejabat')->nullable(); // Pejabat pembuat SK
            $table->string('sk_nomor')->nullable();
            $table->date('sk_tanggal')->nullable();
            $table->text('dasar_peraturan')->nullable();
            $table->timestamps();
        });

        // 2. Pengalaman Jabatan / Pekerjaan
        Schema::create('riwayat_jabatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->string('nama_jabatan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->foreignId('pangkat_id')->nullable()->constrained('pangkats')->nullOnDelete();
            $table->decimal('gaji_pokok', 15, 2)->nullable();
            $table->string('sk_pejabat')->nullable();
            $table->string('sk_nomor')->nullable();
            $table->date('sk_tanggal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_jabatans');
        Schema::dropIfExists('riwayat_kepangkatans');
    }
};
