<?php

namespace App\Http\Controllers;

use App\Models\DokumenDigital;
use App\Models\Opd;
use App\Models\Pangkat;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        // 1. KPI Kepegawaian
        $totalPegawai = Pegawai::count();
        $totalUserApproved = User::where('is_approved', true)->where('role', 'pegawai')->count();
        $totalUserPending = User::where('is_approved', false)->where('role', 'pegawai')->count();
        $totalOpd = Opd::count();
        $totalDokumen = DokumenDigital::count();

        // 2. Jumlah Total Pegawai per OPD
        $pegawaiPerOpd = Opd::withCount('pegawais')
            ->get()
            ->map(fn ($opd) => [
                'id' => $opd->id,
                'nama' => $opd->singkatan ?: $opd->nama_opd,
                'total' => $opd->pegawais_count,
            ]);

        // 3. Komposisi Berdasarkan Jenis Kelamin
        $genderComposition = [
            'Laki-laki' => Pegawai::where('jenis_kelamin', 'Laki-laki')->count(),
            'Perempuan' => Pegawai::where('jenis_kelamin', 'Perempuan')->count(),
        ];

        // 4. Komposisi Berdasarkan Golongan / Pangkat
        $pangkatComposition = Pangkat::withCount('pegawais')
            ->get()
            ->map(fn ($p) => [
                'golongan' => $p->golongan,
                'pangkat' => $p->pangkat,
                'total' => $p->pegawais_count,
            ]);

        return Inertia::render('Dashboard', [
            'kpi' => [
                'total_pegawai' => $totalPegawai,
                'total_user_approved' => $totalUserApproved,
                'total_user_pending' => $totalUserPending,
                'total_opd' => $totalOpd,
                'total_dokumen' => $totalDokumen,
            ],
            'pegawaiPerOpd' => $pegawaiPerOpd,
            'genderComposition' => $genderComposition,
            'pangkatComposition' => $pangkatComposition,
        ]);
    }
}
