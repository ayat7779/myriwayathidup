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
        // 1. Pendidikan Formal (Dalam dan Luar Negeri)
        Schema::create('pendidikan_formals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->enum('jenis_lokasi', ['Dalam Negeri', 'Luar Negeri'])->default('Dalam Negeri');
            $table->foreignId('pendidikan_degree_id')->nullable()->constrained('pendidikan_degrees')->nullOnDelete();
            $table->string('nama_pendidikan'); // Nama Sekolah / Universitas
            $table->string('jurusan')->nullable();
            $table->string('tahun_lulus')->nullable();
            $table->string('nomor_sttb')->nullable(); // STTB / Tanda Lulus / Ijazah
            $table->string('tempat')->nullable(); // Kota / Negara
            $table->string('nama_pimpinan')->nullable(); // Kepala Sekolah / Direktur / Dekan / Promotor
            $table->timestamps();
        });

        // 2. Kursus / Latihan (Dalam dan Luar Negeri)
        Schema::create('pendidikan_kursuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->enum('jenis_lokasi', ['Dalam Negeri', 'Luar Negeri'])->default('Dalam Negeri');
            $table->string('nama_kursus');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('tahun_ijazah')->nullable();
            $table->string('nomor_ijazah')->nullable();
            $table->string('tempat')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendidikan_kursuses');
        Schema::dropIfExists('pendidikan_formals');
    }
};
