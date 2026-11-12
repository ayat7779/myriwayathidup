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
        // 1. Keterangan Keluarga (Istri/Suami, Anak, Bapak/Ibu Kandung, Bapak/Ibu Mertua, Saudara Kandung)
        Schema::create('keterangan_keluargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->enum('hub_keluarga', [
                'Istri',
                'Suami',
                'Anak',
                'Bapak Kandung',
                'Ibu Kandung',
                'Bapak Mertua',
                'Ibu Mertua',
                'Saudara Kandung',
            ]);
            $table->string('nama');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->integer('umur')->nullable();
            $table->date('tanggal_nikah')->nullable(); // Khusus Istri/Suami
            $table->string('pekerjaan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // 2. Keterangan Organisasi (3 Periode)
        Schema::create('keterangan_organisasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->enum('periode', [
                'SLTA ke bawah',
                'Perguruan Tinggi',
                'Sesudah Pendidikan / Selama Pegawai',
            ]);
            $table->string('nama_organisasi');
            $table->string('kedudukan'); // Kedudukan / Jabatan dalam organisasi
            $table->string('tahun_mulai')->nullable();
            $table->string('tahun_selesai')->nullable();
            $table->string('tempat')->nullable();
            $table->string('nama_pimpinan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keterangan_organisasis');
        Schema::dropIfExists('keterangan_keluargas');
    }
};
