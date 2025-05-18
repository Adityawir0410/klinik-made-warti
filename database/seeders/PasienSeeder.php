<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PasienSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pasien')->insert([
            ['id_pasien' => 'P001', 'nama_pasien' => 'Ani Suryani', 'alamat_pasien' => 'Jl. Mawar No. 1'],
            ['id_pasien' => 'P002', 'nama_pasien' => 'Budi Hartono', 'alamat_pasien' => 'Jl. Melati No. 2'],
        ]);
    }
}
