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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nip')->unique(); // Primary key / identifier for ASN
            $table->string('nik')->nullable();
            $table->string('nama_lengkap');
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->foreignId('opd_id')->nullable()->constrained('opds')->nullOnDelete();
            $table->foreignId('pangkat_id')->nullable()->constrained('pangkats')->nullOnDelete();
            $table->string('jabatan_saat_ini')->nullable();

            // Tempat & Tanggal Lahir
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');

            // Demografi
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya'])->default('Islam');
            $table->enum('status_perkawinan', ['Belum Kawin', 'Kawin', 'Janda', 'Duda'])->default('Belum Kawin');

            // Alamat Domisili
            $table->text('alamat_domisili')->nullable();
            $table->foreignId('province_id')->nullable()->constrained('provinces')->nullOnDelete();
            $table->foreignId('regency_id')->nullable()->constrained('regencies')->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete();
            $table->foreignId('village_id')->nullable()->constrained('villages')->nullOnDelete();

            // Keterangan Badan
            $table->integer('tinggi_cm')->nullable();
            $table->integer('berat_badan_kg')->nullable();
            $table->string('rambut')->nullable();
            $table->string('bentuk_muka')->nullable();
            $table->string('warna_kulit')->nullable();
            $table->string('ciri_khas')->nullable();
            $table->string('cacat_tubuh')->nullable();

            // Kegemaran (Hobby)
            $table->text('hobby')->nullable();

            // Foto Profil
            $table->string('foto_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
