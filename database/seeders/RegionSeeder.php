<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $province = Province::updateOrCreate(
            ['kode' => '14'],
            ['nama' => 'Riau']
        );

        $regency = Regency::updateOrCreate(
            ['kode' => '1471'],
            ['province_id' => $province->id, 'nama' => 'Kota Pekanbaru']
        );

        $district = District::updateOrCreate(
            ['kode' => '147101'],
            ['regency_id' => $regency->id, 'nama' => 'Tampan']
        );

        Village::updateOrCreate(
            ['kode' => '1471011001'],
            ['district_id' => $district->id, 'nama' => 'Simpang Baru']
        );
        Village::updateOrCreate(
            ['kode' => '1471011002'],
            ['district_id' => $district->id, 'nama' => 'Sidomulyo Barat']
        );
    }
}
