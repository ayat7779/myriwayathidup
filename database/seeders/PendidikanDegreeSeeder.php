<?php

namespace Database\Seeders;

use App\Models\PendidikanDegree;
use Illuminate\Database\Seeder;

class PendidikanDegreeSeeder extends Seeder
{
    public function run(): void
    {
        $degrees = [
            'TK',
            'SD',
            'SLTP',
            'SLTA',
            'D1',
            'D2',
            'D3',
            'S1',
            'S2',
            'S3',
            'Spesialis',
            'Profesi',
        ];

        foreach ($degrees as $index => $nama) {
            PendidikanDegree::updateOrCreate(
                ['nama' => $nama],
                ['urutan' => $index + 1]
            );
        }
    }
}
