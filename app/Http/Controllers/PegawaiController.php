<?php

namespace App\Http\Controllers;

use App\Models\DokumenDigital;
use App\Models\KeteranganKeluarga;
use App\Models\KeteranganOrganisasi;
use App\Models\KunjunganLuarNegeri;
use App\Models\Opd;
use App\Models\Pangkat;
use App\Models\Pegawai;
use App\Models\PendidikanDegree;
use App\Models\PendidikanFormal;
use App\Models\PendidikanKursus;
use App\Models\Province;
use App\Models\RiwayatJabatan;
use App\Models\RiwayatKepangkatan;
use App\Models\TandaJasa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PegawaiController extends Controller
{
    /**
     * List all Pegawais for Admin / OPD Admin
     */
    public function index(Request $request): Response
    {
        $search = $request->input('search');
        $opdId = $request->input('opd_id');

        $query = Pegawai::with(['opd', 'pangkat']);

        // OPD Admin can only view pegawais in their OPD
        if (auth()->user()->isOpdAdmin()) {
            $query->where('opd_id', auth()->user()->opd_id);
        } elseif ($opdId) {
            $query->where('opd_id', $opdId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('jabatan_saat_ini', 'like', "%{$search}%");
            });
        }

        $pegawais = $query->orderBy('nama_lengkap')->paginate(10)->withQueryString();

        return Inertia::render('Pegawai/Index', [
            'pegawais' => $pegawais,
            'opds' => Opd::select('id', 'nama_opd', 'singkatan')->get(),
            'filters' => [
                'search' => $search,
                'opd_id' => $opdId,
            ],
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
            ],
        ]);
    }

    /**
     * View & Edit own Pegawai DRH Profile
     */
    public function profil(Request $request): Response
    {
        $user = auth()->user();

        $pegawai = Pegawai::where('user_id', $user->id)
            ->orWhere('nip', $user->nip)
            ->with([
                'opd',
                'pangkat',
                'province',
                'regency',
                'district',
                'village',
                'pendidikanFormals.degree',
                'pendidikanKursuses',
                'riwayatKepangkatans.pangkat',
                'riwayatJabatans.pangkat',
                'tandaJasas',
                'kunjunganLuarNegeris',
                'keteranganKeluargas',
                'keteranganOrganisasis',
                'dokumenDigitals',
            ])
            ->first();

        if (! $pegawai) {
            $pegawai = Pegawai::create([
                'user_id' => $user->id,
                'nip' => $user->nip ?: '19900101'.time(),
                'nama_lengkap' => $user->name,
                'opd_id' => $user->opd_id,
                'tempat_lahir' => '-',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'Laki-laki',
            ]);
            $pegawai->load([
                'opd',
                'pangkat',
                'province',
                'regency',
                'district',
                'village',
                'pendidikanFormals.degree',
                'pendidikanKursuses',
                'riwayatKepangkatans.pangkat',
                'riwayatJabatans.pangkat',
                'tandaJasas',
                'kunjunganLuarNegeris',
                'keteranganKeluargas',
                'keteranganOrganisasis',
                'dokumenDigitals',
            ]);
        }

        return Inertia::render('Pegawai/Profil', [
            'pegawai' => $pegawai,
            'opds' => Opd::select('id', 'nama_opd', 'singkatan')->get(),
            'pangkats' => Pangkat::orderBy('tingkat')->get(),
            'pendidikanDegrees' => PendidikanDegree::orderBy('urutan')->get(),
            'provinces' => Province::orderBy('nama')->get(),
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
            ],
        ]);
    }

    /**
     * Show DRH for specific Pegawai (Admin / OPD Admin view)
     */
    public function show(Pegawai $pegawai): Response
    {
        $pegawai->load([
            'opd',
            'pangkat',
            'province',
            'regency',
            'district',
            'village',
            'pendidikanFormals.degree',
            'pendidikanKursuses',
            'riwayatKepangkatans.pangkat',
            'riwayatJabatans.pangkat',
            'tandaJasas',
            'kunjunganLuarNegeris',
            'keteranganKeluargas',
            'keteranganOrganisasis',
            'dokumenDigitals',
        ]);

        return Inertia::render('Pegawai/Show', [
            'pegawai' => $pegawai,
        ]);
    }

    /**
     * 1. Update Keterangan Perorangan & Badan
     */
    public function updateKeteranganPerorangan(Request $request, Pegawai $pegawai): RedirectResponse
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'nip' => 'required|string|max:50|unique:pegawais,nip,'.$pegawai->id,
            'nik' => 'nullable|string|max:50',
            'opd_id' => 'required|exists:opds,id',
            'pangkat_id' => 'nullable|exists:pangkats,id',
            'jabatan_saat_ini' => 'nullable|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string',
            'status_perkawinan' => 'required|string',
            'alamat_domisili' => 'nullable|string',
            'province_id' => 'nullable|exists:provinces,id',
            'regency_id' => 'nullable|exists:regencies,id',
            'district_id' => 'nullable|exists:districts,id',
            'village_id' => 'nullable|exists:villages,id',
            'tinggi_cm' => 'nullable|integer',
            'berat_badan_kg' => 'nullable|integer',
            'rambut' => 'nullable|string|max:100',
            'bentuk_muka' => 'nullable|string|max:100',
            'warna_kulit' => 'nullable|string|max:100',
            'ciri_khas' => 'nullable|string|max:255',
            'cacat_tubuh' => 'nullable|string|max:255',
            'hobby' => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $request->validate(['foto' => 'image|mimes:jpeg,png,jpg|max:2048']);
            if ($pegawai->foto_path) {
                Storage::disk('public')->delete($pegawai->foto_path);
            }
            $validated['foto_path'] = $request->file('foto')->store('pegawai_foto', 'public');
        }

        $pegawai->update($validated);

        return redirect()->back()->with('success', 'Data Keterangan Perorangan berhasil disimpan!');
    }

    /**
     * 2a. Store / Delete Pendidikan Formal
     */
    public function storePendidikanFormal(Request $request, Pegawai $pegawai): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_lokasi' => 'required|in:Dalam Negeri,Luar Negeri',
            'pendidikan_degree_id' => 'required|exists:pendidikan_degrees,id',
            'nama_pendidikan' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'tahun_lulus' => 'required|string|max:10',
            'nomor_sttb' => 'nullable|string|max:255',
            'tempat' => 'required|string|max:255',
            'nama_pimpinan' => 'nullable|string|max:255',
        ]);

        $pegawai->pendidikanFormals()->create($validated);

        return redirect()->back()->with('success', 'Data Pendidikan Formal berhasil ditambahkan!');
    }

    public function destroyPendidikanFormal(PendidikanFormal $pendidikanFormal): RedirectResponse
    {
        $pendidikanFormal->delete();

        return redirect()->back()->with('success', 'Data Pendidikan Formal dihapus.');
    }

    /**
     * 2b. Store / Delete Pendidikan Kursus
     */
    public function storePendidikanKursus(Request $request, Pegawai $pegawai): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_lokasi' => 'required|in:Dalam Negeri,Luar Negeri',
            'nama_kursus' => 'required|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'tahun_ijazah' => 'nullable|string|max:20',
            'nomor_ijazah' => 'nullable|string|max:255',
            'tempat' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $pegawai->pendidikanKursuses()->create($validated);

        return redirect()->back()->with('success', 'Data Kursus / Pelatihan berhasil ditambahkan!');
    }

    public function destroyPendidikanKursus(PendidikanKursus $pendidikanKursus): RedirectResponse
    {
        $pendidikanKursus->delete();

        return redirect()->back()->with('success', 'Data Kursus / Pelatihan dihapus.');
    }

    /**
     * 3a. Store / Delete Riwayat Kepangkatan
     */
    public function storeRiwayatKepangkatan(Request $request, Pegawai $pegawai): RedirectResponse
    {
        $validated = $request->validate([
            'pangkat_id' => 'required|exists:pangkats,id',
            'tmt_pangkat' => 'required|date',
            'gaji_pokok' => 'required|numeric|min:0',
            'sk_pejabat' => 'required|string|max:255',
            'sk_nomor' => 'required|string|max:255',
            'sk_tanggal' => 'required|date',
            'dasar_peraturan' => 'nullable|string',
        ]);

        $pegawai->riwayatKepangkatans()->create($validated);

        return redirect()->back()->with('success', 'Data Riwayat Kepangkatan berhasil ditambahkan!');
    }

    public function destroyRiwayatKepangkatan(RiwayatKepangkatan $riwayatKepangkatan): RedirectResponse
    {
        $riwayatKepangkatan->delete();

        return redirect()->back()->with('success', 'Data Riwayat Kepangkatan dihapus.');
    }

    /**
     * 3b. Store / Delete Riwayat Jabatan
     */
    public function storeRiwayatJabatan(Request $request, Pegawai $pegawai): RedirectResponse
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'pangkat_id' => 'nullable|exists:pangkats,id',
            'gaji_pokok' => 'nullable|numeric|min:0',
            'sk_pejabat' => 'nullable|string|max:255',
            'sk_nomor' => 'nullable|string|max:255',
            'sk_tanggal' => 'nullable|date',
        ]);

        $pegawai->riwayatJabatans()->create($validated);

        return redirect()->back()->with('success', 'Data Riwayat Jabatan berhasil ditambahkan!');
    }

    public function destroyRiwayatJabatan(RiwayatJabatan $riwayatJabatan): RedirectResponse
    {
        $riwayatJabatan->delete();

        return redirect()->back()->with('success', 'Data Riwayat Jabatan dihapus.');
    }

    /**
     * 4. Store / Delete Tanda Jasa
     */
    public function storeTandaJasa(Request $request, Pegawai $pegawai): RedirectResponse
    {
        $validated = $request->validate([
            'nama_penghargaan' => 'required|string|max:255',
            'tahun_perolehan' => 'required|string|max:20',
            'instansi_pemberi' => 'required|string|max:255',
        ]);

        $pegawai->tandaJasas()->create($validated);

        return redirect()->back()->with('success', 'Data Tanda Jasa / Penghargaan berhasil ditambahkan!');
    }

    public function destroyTandaJasa(TandaJasa $tandaJasa): RedirectResponse
    {
        $tandaJasa->delete();

        return redirect()->back()->with('success', 'Data Tanda Jasa dihapus.');
    }

    /**
     * 5. Store / Delete Kunjungan Luar Negeri
     */
    public function storeKunjunganLuarNegeri(Request $request, Pegawai $pegawai): RedirectResponse
    {
        $validated = $request->validate([
            'negara_tujuan' => 'required|string|max:255',
            'tujuan_kunjungan' => 'required|string|max:255',
            'lama_kunjungan' => 'required|string|max:100',
            'yang_membiayai' => 'required|string|max:255',
        ]);

        $pegawai->kunjunganLuarNegeris()->create($validated);

        return redirect()->back()->with('success', 'Data Kunjungan Luar Negeri berhasil ditambahkan!');
    }

    public function destroyKunjunganLuarNegeri(KunjunganLuarNegeri $kunjunganLuarNegeri): RedirectResponse
    {
        $kunjunganLuarNegeri->delete();

        return redirect()->back()->with('success', 'Data Kunjungan Luar Negeri dihapus.');
    }

    /**
     * 6. Store / Delete Keterangan Keluarga
     */
    public function storeKeteranganKeluarga(Request $request, Pegawai $pegawai): RedirectResponse
    {
        $validated = $request->validate([
            'hub_keluarga' => 'required|string',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'umur' => 'nullable|integer',
            'tanggal_nikah' => 'nullable|date',
            'pekerjaan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $pegawai->keteranganKeluargas()->create($validated);

        return redirect()->back()->with('success', 'Data Keterangan Keluarga berhasil ditambahkan!');
    }

    public function destroyKeteranganKeluarga(KeteranganKeluarga $keteranganKeluarga): RedirectResponse
    {
        $keteranganKeluarga->delete();

        return redirect()->back()->with('success', 'Data Keterangan Keluarga dihapus.');
    }

    /**
     * 7. Store / Delete Keterangan Organisasi
     */
    public function storeKeteranganOrganisasi(Request $request, Pegawai $pegawai): RedirectResponse
    {
        $validated = $request->validate([
            'periode' => 'required|string',
            'nama_organisasi' => 'required|string|max:255',
            'kedudukan' => 'required|string|max:255',
            'tahun_mulai' => 'required|string|max:10',
            'tahun_selesai' => 'required|string|max:10',
            'tempat' => 'required|string|max:255',
            'nama_pimpinan' => 'nullable|string|max:255',
        ]);

        $pegawai->keteranganOrganisasis()->create($validated);

        return redirect()->back()->with('success', 'Data Keterangan Organisasi berhasil ditambahkan!');
    }

    public function destroyKeteranganOrganisasi(KeteranganOrganisasi $keteranganOrganisasi): RedirectResponse
    {
        $keteranganOrganisasi->delete();

        return redirect()->back()->with('success', 'Data Keterangan Organisasi dihapus.');
    }

    /**
     * 8. Store / Delete Dokumen Digital Upload
     */
    public function storeDokumenDigital(Request $request, Pegawai $pegawai): RedirectResponse
    {
        $request->validate([
            'kategori' => 'required|string',
            'nama_dokumen' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        $file = $request->file('file');
        $filePath = $file->store('dokumen_pegawai/'.$pegawai->nip, 'public');

        $pegawai->dokumenDigitals()->create([
            'kategori' => $request->kategori,
            'nama_dokumen' => $request->nama_dokumen,
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ]);

        return redirect()->back()->with('success', 'Dokumen Digital berhasil diupload!');
    }

    public function destroyDokumenDigital(DokumenDigital $dokumenDigital): RedirectResponse
    {
        if ($dokumenDigital->file_path) {
            Storage::disk('public')->delete($dokumenDigital->file_path);
        }

        $dokumenDigital->delete();

        return redirect()->back()->with('success', 'Dokumen Digital berhasil dihapus.');
    }

    /**
     * Print Official DRH View
     */
    public function cetakDrh(Pegawai $pegawai)
    {
        $pegawai->load([
            'opd',
            'pangkat',
            'pendidikanFormals.degree',
            'pendidikanKursuses',
            'riwayatKepangkatans.pangkat',
            'riwayatJabatans.pangkat',
            'tandaJasas',
            'kunjunganLuarNegeris',
            'keteranganKeluargas',
            'keteranganOrganisasis',
        ]);

        return view('drh_print', [
            'pegawai' => $pegawai,
        ]);
    }

    /**
     * Export Pegawai Data to CSV/Excel
     */
    public function exportCsv(Request $request)
    {
        $opdId = $request->input('opd_id');
        $pangkatId = $request->input('pangkat_id');

        $query = Pegawai::with(['opd', 'pangkat', 'user']);

        if (auth()->user()->isOpdAdmin()) {
            $query->where('opd_id', auth()->user()->opd_id);
        } elseif ($opdId) {
            $query->where('opd_id', $opdId);
        }

        if ($pangkatId) {
            $query->where('pangkat_id', $pangkatId);
        }

        $pegawais = $query->orderBy('nama_lengkap')->get();

        $fileName = 'Rekap_Pegawai_ASN_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($pegawais) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

            fputcsv($file, [
                'No',
                'NIP',
                'NIK',
                'Nama Lengkap',
                'Gelar Depan',
                'Gelar Belakang',
                'OPD / Unit Kerja',
                'Golongan',
                'Nama Pangkat',
                'Jabatan Saat Ini',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Jenis Kelamin',
                'Agama',
                'Status Perkawinan',
                'Alamat Domisili',
                'No Telepon',
                'Email',
            ]);

            foreach ($pegawais as $index => $p) {
                fputcsv($file, [
                    $index + 1,
                    $p->nip,
                    $p->nik ?? '',
                    $p->nama_lengkap,
                    $p->gelar_depan ?? '',
                    $p->gelar_belakang ?? '',
                    $p->opd ? $p->opd->nama_opd : '',
                    $p->pangkat ? $p->pangkat->golongan : '',
                    $p->pangkat ? $p->pangkat->pangkat : '',
                    $p->jabatan_saat_ini ?? '',
                    $p->tempat_lahir,
                    $p->tanggal_lahir ? $p->tanggal_lahir->format('Y-m-d') : '',
                    $p->jenis_kelamin,
                    $p->agama,
                    $p->status_perkawinan,
                    $p->alamat_domisili ?? '',
                    $p->user ? $p->user->phone : '',
                    $p->user ? $p->user->email : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
