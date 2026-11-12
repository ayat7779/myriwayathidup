<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>DAFTAR RIWAYAT HIDUP - {{ $pegawai->nama_lengkap }} (NIP: {{ $pegawai->nip }})</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 12mm 15mm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.3;
            color: #000;
            background: #fff;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }

        .header-title {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #000;
            padding: 4px 6px;
            font-size: 10pt;
        }

        .table-bordered th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .section-header {
            font-weight: bold;
            font-size: 11pt;
            background-color: #e6e6e6;
            border: 1px solid #000;
            padding: 4px 8px;
            margin-top: 12px;
            margin-bottom: 6px;
        }

        .field-label { width: 30%; }
        .field-colon { width: 3%; }
        .field-value { width: 67%; }

        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="background: #334155; padding: 10px; text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="background: #4f46e5; color: white; border: none; padding: 10px 20px; font-weight: bold; border-radius: 6px; cursor: pointer;">
            🖨️ Cetak / Simpan sebagai PDF (DRH Official)
        </button>
    </div>

    <!-- Header DRH -->
    <div class="text-center" style="margin-bottom: 20px;">
        <div class="header-title">DAFTAR RIWAYAT HIDUP</div>
        <div style="font-size: 10pt;">Sistem Informasi Riwayat Hidup Digital ASN</div>
    </div>

    <!-- I. KETERANGAN PERORANGAN -->
    <div class="section-header">I. KETERANGAN PERORANGAN</div>
    <table>
        <tr>
            <td class="field-label">1. Nama Lengkap</td>
            <td class="field-colon">:</td>
            <td class="field-value font-bold">{{ $pegawai->gelar_depan ? $pegawai->gelar_depan . ' ' : '' }}{{ $pegawai->nama_lengkap }}{{ $pegawai->gelar_belakang ? ', ' . $pegawai->gelar_belakang : '' }}</td>
        </tr>
        <tr>
            <td class="field-label">2. NIP</td>
            <td class="field-colon">:</td>
            <td class="field-value">{{ $pegawai->nip }}</td>
        </tr>
        <tr>
            <td class="field-label">3. NIK KTP</td>
            <td class="field-colon">:</td>
            <td class="field-value">{{ $pegawai->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td class="field-label">4. Pangkat dan Golongan Ruang</td>
            <td class="field-colon">:</td>
            <td class="field-value">{{ $pegawai->pangkat ? $pegawai->pangkat->pangkat . ' / Gol. ' . $pegawai->pangkat->golongan : '-' }}</td>
        </tr>
        <tr>
            <td class="field-label">5. Jabatan Saat Ini</td>
            <td class="field-colon">:</td>
            <td class="field-value">{{ $pegawai->jabatan_saat_ini ?? '-' }}</td>
        </tr>
        <tr>
            <td class="field-label">6. Unit Kerja / OPD</td>
            <td class="field-colon">:</td>
            <td class="field-value">{{ $pegawai->opd ? $pegawai->opd->nama_opd : '-' }}</td>
        </tr>
        <tr>
            <td class="field-label">7. Tempat, Tanggal Lahir</td>
            <td class="field-colon">:</td>
            <td class="field-value">{{ $pegawai->tempat_lahir }}, {{ \Carbon\Carbon::parse($pegawai->tanggal_lahir)->isoFormat('D MMMM Y') }}</td>
        </tr>
        <tr>
            <td class="field-label">8. Jenis Kelamin</td>
            <td class="field-colon">:</td>
            <td class="field-value">{{ $pegawai->jenis_kelamin }}</td>
        </tr>
        <tr>
            <td class="field-label">9. Agama</td>
            <td class="field-colon">:</td>
            <td class="field-value">{{ $pegawai->agama }}</td>
        </tr>
        <tr>
            <td class="field-label">10. Status Perkawinan</td>
            <td class="field-colon">:</td>
            <td class="field-value">{{ $pegawai->status_perkawinan }}</td>
        </tr>
        <tr>
            <td class="field-label">11. Alamat Domisili</td>
            <td class="field-colon">:</td>
            <td class="field-value">{{ $pegawai->alamat_domisili ?? '-' }}</td>
        </tr>
        <tr>
            <td class="field-label">12. Keterangan Badan</td>
            <td class="field-colon">:</td>
            <td class="field-value">
                Tinggi: {{ $pegawai->tinggi_cm ?? '-' }} cm, Berat: {{ $pegawai->berat_badan_kg ?? '-' }} kg,
                Rambut: {{ $pegawai->rambut ?? '-' }}, Muka: {{ $pegawai->bentuk_muka ?? '-' }}, Kulit: {{ $pegawai->warna_kulit ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="field-label">13. Kegemaran (Hobby)</td>
            <td class="field-colon">:</td>
            <td class="field-value">{{ $pegawai->hobby ?? '-' }}</td>
        </tr>
    </table>

    <!-- II. PENDIDIKAN FORMAL -->
    <div class="section-header">II. PENDIDIKAN FORMAL & KURSUS</div>
    <div style="font-weight: bold; margin-bottom: 4px; font-size: 10pt;">1. Pendidikan Formal:</div>
    <table class="table-bordered">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tingkat</th>
                <th style="width: 35%;">Nama Sekolah / Perguruan Tinggi</th>
                <th style="width: 20%;">Jurusan</th>
                <th style="width: 15%;">Tahun Lulus</th>
                <th style="width: 10%;">Tempat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pegawai->pendidikanFormals as $idx => $pf)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>{{ $pf->degree ? $pf->degree->nama : '-' }}</td>
                <td>{{ $pf->nama_pendidikan }}</td>
                <td>{{ $pf->jurusan ?? '-' }}</td>
                <td class="text-center">{{ $pf->tahun_lulus }}</td>
                <td>{{ $pf->tempat }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">- Tidak ada data -</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="font-weight: bold; margin-bottom: 4px; font-size: 10pt;">2. Kursus / Pelatihan:</div>
    <table class="table-bordered">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 40%;">Nama Kursus / Pelatihan</th>
                <th style="width: 25%;">Lama / Tanggal</th>
                <th style="width: 15%;">No Ijazah</th>
                <th style="width: 15%;">Tempat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pegawai->pendidikanKursuses as $idx => $pk)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>{{ $pk->nama_kursus }}</td>
                <td>{{ $pk->tanggal_mulai ? \Carbon\Carbon::parse($pk->tanggal_mulai)->format('d/m/Y') : '' }} s/d {{ $pk->tanggal_selesai ? \Carbon\Carbon::parse($pk->tanggal_selesai)->format('d/m/Y') : '' }}</td>
                <td>{{ $pk->nomor_ijazah ?? '-' }}</td>
                <td>{{ $pk->tempat }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">- Tidak ada data -</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- III. RIWAYAT KEPANGKATAN & JABATAN -->
    <div class="section-header">III. RIWAYAT KEPANGKATAN & JABATAN</div>
    <div style="font-weight: bold; margin-bottom: 4px; font-size: 10pt;">1. Riwayat Kepangkatans Penggajian:</div>
    <table class="table-bordered">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Golongan / Pangkat</th>
                <th style="width: 15%;">TMT</th>
                <th style="width: 20%;">Gaji Pokok</th>
                <th style="width: 35%;">SK (Pejabat / No / Tanggal)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pegawai->riwayatKepangkatans as $idx => $rk)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>Gol. {{ $rk->pangkat ? $rk->pangkat->golongan : '-' }} ({{ $rk->pangkat ? $rk->pangkat->pangkat : '-' }})</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($rk->tmt_pangkat)->format('d/m/Y') }}</td>
                <td>Rp {{ number_format($rk->gaji_pokok, 0, ',', '.') }}</td>
                <td>{{ $rk->sk_pejabat }} / {{ $rk->sk_nomor }} / {{ $rk->sk_tanggal ? \Carbon\Carbon::parse($rk->sk_tanggal)->format('d/m/Y') : '' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">- Tidak ada data -</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- IV. TANDA JASA & KUNJUNGAN -->
    <div class="section-header">IV. TANDA JASA & KUNJUNGAN LUAR NEGERI</div>
    <table class="table-bordered">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 45%;">Nama Bintang / Satya Lencana / Penghargaan</th>
                <th style="width: 20%;">Tahun Perolehan</th>
                <th style="width: 30%;">Instansi Pemberi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pegawai->tandaJasas as $idx => $tj)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>{{ $tj->nama_penghargaan }}</td>
                <td class="text-center">{{ $tj->tahun_perolehan }}</td>
                <td>{{ $tj->instansi_pemberi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">- Tidak ada data -</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- V. KETERANGAN KELUARGA -->
    <div class="section-header">V. KETERANGAN KELUARGA</div>
    <table class="table-bordered">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Hub. Keluarga</th>
                <th style="width: 35%;">Nama Lengkap</th>
                <th style="width: 20%;">TTL / Umur</th>
                <th style="width: 20%;">Pekerjaan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pegawai->keteranganKeluargas as $idx => $kk)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td class="font-bold">{{ $kk->hub_keluarga }}</td>
                <td>{{ $kk->nama }}</td>
                <td>{{ $kk->tempat_lahir }}, {{ $kk->tanggal_lahir ? \Carbon\Carbon::parse($kk->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
                <td>{{ $kk->pekerjaan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">- Tidak ada data -</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Signatures -->
    <div style="margin-top: 30px; width: 100%; display: flex; justify-content: space-between;">
        <div style="width: 40%; text-align: center;">
            <br>
            <div>Mengetahui,</div>
            <div style="font-weight: bold;">Kepala {{ $pegawai->opd ? $pegawai->opd->singkatan : 'OPD' }}</div>
            <br><br><br><br>
            <div style="font-weight: bold; text-decoration: underline;">{{ $pegawai->opd ? $pegawai->opd->kepala_opd : '.........................................' }}</div>
            <div>NIP. {{ $pegawai->opd ? $pegawai->opd->nip_kepala : '.........................................' }}</div>
        </div>

        <div style="width: 40%; text-align: center;">
            <div>Pekanbaru, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</div>
            <div>Yang membuat pernyataan,</div>
            <br><br><br><br>
            <div style="font-weight: bold; text-decoration: underline;">{{ $pegawai->nama_lengkap }}</div>
            <div>NIP. {{ $pegawai->nip }}</div>
        </div>
    </div>

</body>
</html>
