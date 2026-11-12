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
        Schema::create('dokumen_digitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->string('kategori'); // KTP, NPWP, SK CPNS, SK PNS, SK Pangkat, SK Jabatan, Ijazah, Transkrip, Sertifikat, KK, Lainnya
            $table->string('nama_dokumen');
            $table->string('file_path');
            $table->bigInteger('file_size')->nullable(); // dalam bytes
            $table->string('mime_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_digitals');
    }
};
