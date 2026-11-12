<?php

use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\OpdController;
use App\Http\Controllers\Master\PangkatController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RegionController;
use App\Http\Middleware\EnsureUserIsApproved;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Welcome Page
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Pending Approval Page for unapproved users
    Route::get('/pending-approval', function () {
        return Inertia::render('Auth/PendingApproval');
    })->name('pending-approval');

    // Routes requiring Admin Approval
    Route::middleware(EnsureUserIsApproved::class)->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Pegawai DRH Management Routes
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::get('/pegawai-export', [PegawaiController::class, 'exportCsv'])->name('pegawai.exportCsv');
        Route::get('/pegawai/profil', [PegawaiController::class, 'profil'])->name('pegawai.profil');
        Route::get('/pegawai/{pegawai}', [PegawaiController::class, 'show'])->name('pegawai.show');
        Route::get('/pegawai/{pegawai}/cetak-drh', [PegawaiController::class, 'cetakDrh'])->name('pegawai.cetakDrh');

        Route::post('/pegawai/{pegawai}/keterangan-perorangan', [PegawaiController::class, 'updateKeteranganPerorangan'])->name('pegawai.updateKeteranganPerorangan');

        Route::post('/pegawai/{pegawai}/pendidikan-formal', [PegawaiController::class, 'storePendidikanFormal'])->name('pegawai.storePendidikanFormal');
        Route::delete('/pegawai/pendidikan-formal/{pendidikanFormal}', [PegawaiController::class, 'destroyPendidikanFormal'])->name('pegawai.destroyPendidikanFormal');

        Route::post('/pegawai/{pegawai}/pendidikan-kursus', [PegawaiController::class, 'storePendidikanKursus'])->name('pegawai.storePendidikanKursus');
        Route::delete('/pegawai/pendidikan-kursus/{pendidikanKursus}', [PegawaiController::class, 'destroyPendidikanKursus'])->name('pegawai.destroyPendidikanKursus');

        Route::post('/pegawai/{pegawai}/riwayat-kepangkatan', [PegawaiController::class, 'storeRiwayatKepangkatan'])->name('pegawai.storeRiwayatKepangkatan');
        Route::delete('/pegawai/riwayat-kepangkatan/{riwayatKepangkatan}', [PegawaiController::class, 'destroyRiwayatKepangkatan'])->name('pegawai.destroyRiwayatKepangkatan');

        Route::post('/pegawai/{pegawai}/riwayat-jabatan', [PegawaiController::class, 'storeRiwayatJabatan'])->name('pegawai.storeRiwayatJabatan');
        Route::delete('/pegawai/riwayat-jabatan/{riwayatJabatan}', [PegawaiController::class, 'destroyRiwayatJabatan'])->name('pegawai.destroyRiwayatJabatan');

        Route::post('/pegawai/{pegawai}/tanda-jasa', [PegawaiController::class, 'storeTandaJasa'])->name('pegawai.storeTandaJasa');
        Route::delete('/pegawai/tanda-jasa/{tandaJasa}', [PegawaiController::class, 'destroyTandaJasa'])->name('pegawai.destroyTandaJasa');

        Route::post('/pegawai/{pegawai}/kunjungan-luar-negeri', [PegawaiController::class, 'storeKunjunganLuarNegeri'])->name('pegawai.storeKunjunganLuarNegeri');
        Route::delete('/pegawai/kunjungan-luar-negeri/{kunjunganLuarNegeri}', [PegawaiController::class, 'destroyKunjunganLuarNegeri'])->name('pegawai.destroyKunjunganLuarNegeri');

        Route::post('/pegawai/{pegawai}/keterangan-keluarga', [PegawaiController::class, 'storeKeteranganKeluarga'])->name('pegawai.storeKeteranganKeluarga');
        Route::delete('/pegawai/keterangan-keluarga/{keteranganKeluarga}', [PegawaiController::class, 'destroyKeteranganKeluarga'])->name('pegawai.destroyKeteranganKeluarga');

        Route::post('/pegawai/{pegawai}/keterangan-organisasi', [PegawaiController::class, 'storeKeteranganOrganisasi'])->name('pegawai.storeKeteranganOrganisasi');
        Route::delete('/pegawai/keterangan-organisasi/{keteranganOrganisasi}', [PegawaiController::class, 'destroyKeteranganOrganisasi'])->name('pegawai.destroyKeteranganOrganisasi');

        Route::post('/pegawai/{pegawai}/dokumen-digital', [PegawaiController::class, 'storeDokumenDigital'])->name('pegawai.storeDokumenDigital');
        Route::delete('/pegawai/dokumen-digital/{dokumenDigital}', [PegawaiController::class, 'destroyDokumenDigital'])->name('pegawai.destroyDokumenDigital');

        // Admin User Approval Management
        Route::get('/admin/users', [UserApprovalController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users/{user}/approve', [UserApprovalController::class, 'approve'])->name('admin.users.approve');
        Route::post('/admin/users/{user}/reject', [UserApprovalController::class, 'reject'])->name('admin.users.reject');

        // Data Master OPD Management
        Route::get('/master/opd', [OpdController::class, 'index'])->name('master.opd.index');
        Route::post('/master/opd', [OpdController::class, 'store'])->name('master.opd.store');
        Route::put('/master/opd/{opd}', [OpdController::class, 'update'])->name('master.opd.update');
        Route::delete('/master/opd/{opd}', [OpdController::class, 'destroy'])->name('master.opd.destroy');

        // Data Master Pangkat Management
        Route::get('/master/pangkat', [PangkatController::class, 'index'])->name('master.pangkat.index');
        Route::post('/master/pangkat', [PangkatController::class, 'store'])->name('master.pangkat.store');
        Route::put('/master/pangkat/{pangkat}', [PangkatController::class, 'update'])->name('master.pangkat.update');
        Route::delete('/master/pangkat/{pangkat}', [PangkatController::class, 'destroy'])->name('master.pangkat.destroy');

        // API Region Cascade Routes
        Route::get('/api/provinces', [RegionController::class, 'provinces'])->name('api.provinces');
        Route::get('/api/provinces/{province}/regencies', [RegionController::class, 'regencies'])->name('api.regencies');
        Route::get('/api/regencies/{regency}/districts', [RegionController::class, 'districts'])->name('api.districts');
        Route::get('/api/districts/{district}/villages', [RegionController::class, 'villages'])->name('api.villages');
    });
});
