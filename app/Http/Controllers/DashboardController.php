<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik umum
        $totalPasien = Pasien::count();
        $totalKunjungan = RekamMedis::count();
        $totalPendapatan = RekamMedis::sum('biaya');

        // Hari ini
        $hariIni = Carbon::today();

        // Pasien & rekam medis hari ini
        $pasienHariIni = Pasien::whereDate('created_at', $hariIni)->count();
        $rekamHariIni = RekamMedis::whereDate('created_at', $hariIni)->count();
        $totalHariIni = $pasienHariIni + $rekamHariIni;

        // Ambil daftar pasien yang daftar hari ini saja (desc agar terbaru di atas)
        $kunjunganHariIni = Pasien::whereDate('created_at', $hariIni)
                                ->orderBy('created_at', 'desc')
                                ->get();

        return view('dashboard', compact(
            'totalPasien',
            'totalKunjungan',
            'totalPendapatan',
            'totalHariIni',
            'kunjunganHariIni'
        ));
    }
}
