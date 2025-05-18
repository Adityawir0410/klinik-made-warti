<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RekamMedisSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rekam_medis')->insert([
            [
                'id_rekam' => 'R001',
                'id_pasien' => 'P001',
                'user_id' => 2, // Bidan
                'tanggal_kunjungan' => '2025-05-01',
                'keluhan' => 'Sakit kepala',
                'biaya' => 100000,
            ],
            [
                'id_rekam' => 'R002',
                'id_pasien' => 'P002',
                'user_id' => 1, // Admin
                'tanggal_kunjungan' => '2025-05-01',
                'keluhan' => 'Pilek berat',
                'biaya' => 120000,
            ]
        ]);
    }
}
