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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable()->unique()->after('id');
            $table->string('nik')->nullable()->unique()->after('nip');
            $table->string('phone')->nullable()->unique()->after('nik');
            $table->string('role')->default('pegawai')->after('password'); // admin, opd_admin, pegawai
            $table->boolean('is_approved')->default(false)->after('role'); // approval status by admin
            $table->foreignId('opd_id')->nullable()->constrained('opds')->nullOnDelete()->after('is_approved');
            $table->timestamp('approved_at')->nullable()->after('opd_id');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()->after('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['opd_id']);
            $table->dropColumn(['nip', 'nik', 'phone', 'role', 'is_approved', 'opd_id', 'approved_at', 'approved_by']);
        });
    }
};
