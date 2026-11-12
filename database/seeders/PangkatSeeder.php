<?php

namespace Database\Seeders;

use App\Models\Pangkat;
use Illuminate\Database\Seeder;

class PangkatSeeder extends Seeder
{
    public function run(): void
    {
        $pangkats = [
            ['golongan' => 'I/a', 'pangkat' => 'Juru Muda', 'tingkat' => 1],
            ['golongan' => 'I/b', 'pangkat' => 'Juru Muda Tingkat I', 'tingkat' => 2],
            ['golongan' => 'I/c', 'pangkat' => 'Juru', 'tingkat' => 3],
            ['golongan' => 'I/d', 'pangkat' => 'Juru Tingkat I', 'tingkat' => 4],
            ['golongan' => 'II/a', 'pangkat' => 'Pengatur Muda', 'tingkat' => 5],
            ['golongan' => 'II/b', 'pangkat' => 'Pengatur Muda Tingkat I', 'tingkat' => 6],
            ['golongan' => 'II/c', 'pangkat' => 'Pengatur', 'tingkat' => 7],
            ['golongan' => 'II/d', 'pangkat' => 'Pengatur Tingkat I', 'tingkat' => 8],
            ['golongan' => 'III/a', 'pangkat' => 'Penata Muda', 'tingkat' => 9],
            ['golongan' => 'III/b', 'pangkat' => 'Penata Muda Tingkat I', 'tingkat' => 10],
            ['golongan' => 'III/c', 'pangkat' => 'Penata', 'tingkat' => 11],
            ['golongan' => 'III/d', 'pangkat' => 'Penata Tingkat I', 'tingkat' => 12],
            ['golongan' => 'IV/a', 'pangkat' => 'Pembina', 'tingkat' => 13],
            ['golongan' => 'IV/b', 'pangkat' => 'Pembina Tingkat I', 'tingkat' => 14],
            ['golongan' => 'IV/c', 'pangkat' => 'Pembina Utama Muda', 'tingkat' => 15],
            ['golongan' => 'IV/d', 'pangkat' => 'Pembina Utama Madya', 'tingkat' => 16],
            ['golongan' => 'IV/e', 'pangkat' => 'Pembina Utama', 'tingkat' => 17],
        ];

        foreach ($pangkats as $data) {
            Pangkat::updateOrCreate(['golongan' => $data['golongan']], $data);
        }
    }
}
