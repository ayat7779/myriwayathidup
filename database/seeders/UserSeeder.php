<?php

namespace Database\Seeders;

use App\Models\Opd;
use App\Models\Pangkat;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $bkpsdm = Opd::where('singkatan', 'BKPSDM')->first();
        $diskominfo = Opd::where('singkatan', 'DISKOMINFO')->first();
        $pangkatPenata = Pangkat::where('golongan', 'III/c')->first();

        // 1. Super Admin Aplikasi
        $admin = User::updateOrCreate(
            ['nip' => '198001012005011001'],
            [
                'name' => 'Administrator Utama',
                'email' => 'admin@riwayathidup.go.id',
                'nik' => '1471010101800001',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_approved' => true,
                'opd_id' => $bkpsdm?->id,
                'approved_at' => now(),
            ]
        );

        // 2. Admin OPD
        $opdAdmin = User::updateOrCreate(
            ['nip' => '198502022008011002'],
            [
                'name' => 'Admin DISKOMINFO',
                'email' => 'admin.kominfo@riwayathidup.go.id',
                'nik' => '1471010202850002',
                'phone' => '081234567891',
                'password' => Hash::make('password'),
                'role' => 'opd_admin',
                'is_approved' => true,
                'opd_id' => $diskominfo?->id,
                'approved_at' => now(),
                'approved_by' => $admin->id,
            ]
        );

        // 3. Pegawai Disetujui (Approved User)
        $pegawaiUser = User::updateOrCreate(
            ['nip' => '199003032014021003'],
            [
                'name' => 'Rahmat Hidayat, S.Kom',
                'email' => 'rahmat.hidayat@riwayathidup.go.id',
                'nik' => '1471010303900003',
                'phone' => '081234567892',
                'password' => Hash::make('password'),
                'role' => 'pegawai',
                'is_approved' => true,
                'opd_id' => $diskominfo?->id,
                'approved_at' => now(),
                'approved_by' => $admin->id,
            ]
        );

        // Create initial Pegawai profile for Rahmat Hidayat
        Pegawai::updateOrCreate(
            ['nip' => '199003032014021003'],
            [
                'user_id' => $pegawaiUser->id,
                'nik' => '1471010303900003',
                'nama_lengkap' => 'Rahmat Hidayat',
                'gelar_depan' => '',
                'gelar_belakang' => 'S.Kom',
                'opd_id' => $diskominfo?->id,
                'pangkat_id' => $pangkatPenata?->id,
                'jabatan_saat_ini' => 'Pranata Komputer Ahli Muda',
                'tempat_lahir' => 'Pekanbaru',
                'tanggal_lahir' => '1990-03-03',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'status_perkawinan' => 'Kawin',
                'alamat_domisili' => 'Jl. HR. Soebrantas No. 123, Tampan, Pekanbaru',
                'tinggi_cm' => 170,
                'berat_badan_kg' => 68,
                'rambut' => 'Lurus Hitam',
                'bentuk_muka' => 'Lonjong',
                'warna_kulit' => 'Sawo Matang',
                'hobby' => 'Membaca, Koding, Bulutangkis',
            ]
        );

        // 4. User Pegawai Baru Register (Pending Approval)
        User::updateOrCreate(
            ['nip' => '199504042020012004'],
            [
                'name' => 'Siti Nurhaliza, S.T',
                'email' => 'siti.nurhaliza@riwayathidup.go.id',
                'nik' => '1471010404950004',
                'phone' => '081234567893',
                'password' => Hash::make('password'),
                'role' => 'pegawai',
                'is_approved' => false, // Needs Admin Approval
                'opd_id' => $diskominfo?->id,
            ]
        );
    }
}
