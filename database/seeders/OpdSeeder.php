<?php

namespace Database\Seeders;

use App\Models\Opd;
use Illuminate\Database\Seeder;

class OpdSeeder extends Seeder
{
    public function run(): void
    {
        $opds = [
            [
                'kode_opd' => 'OPD-001',
                'nama_opd' => 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia',
                'singkatan' => 'BKPSDM',
                'kepala_opd' => 'Drs. H. Ahmad Fauzi, M.Si',
                'nip_kepala' => '196805121992031001',
                'alamat' => 'Jl. Praja No. 1',
            ],
            [
                'kode_opd' => 'OPD-002',
                'nama_opd' => 'Dinas Pendidikan dan Kebudayaan',
                'singkatan' => 'DISDIKBUD',
                'kepala_opd' => 'Dr. Hj. Siti Rahmah, M.Pd',
                'nip_kepala' => '197003151995122002',
                'alamat' => 'Jl. Pendidikan No. 12',
            ],
            [
                'kode_opd' => 'OPD-003',
                'nama_opd' => 'Dinas Kesehatan',
                'singkatan' => 'DINKES',
                'kepala_opd' => 'dr. Bambang Suherman, Sp.PD',
                'nip_kepala' => '197508202000031003',
                'alamat' => 'Jl. Kesehatan No. 45',
            ],
            [
                'kode_opd' => 'OPD-004',
                'nama_opd' => 'Dinas Komunikasi dan Informatika',
                'singkatan' => 'DISKOMINFO',
                'kepala_opd' => 'Ir. Muhammad Aris, M.T',
                'nip_kepala' => '197211101998031004',
                'alamat' => 'Jl. Pemuda No. 88',
            ],
            [
                'kode_opd' => 'OPD-005',
                'nama_opd' => 'Badan Perencanaan Pembangunan Daerah',
                'singkatan' => 'BAPPEDA',
                'kepala_opd' => 'Drs. Eko Prasetyo, M.E',
                'nip_kepala' => '196901011993021005',
                'alamat' => 'Jl. Pembangunan No. 5',
            ],
        ];

        foreach ($opds as $data) {
            Opd::updateOrCreate(['kode_opd' => $data['kode_opd']], $data);
        }
    }
}
