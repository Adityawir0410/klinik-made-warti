<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekamMedis;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->input('jenis', 'tahunan');
        $periode = $request->input('periode') ?? now()->format(match ($jenis) {
            'tahunan' => 'Y',
            'bulanan' => 'Y-m',
            'mingguan' => 'Y-m-d',
            default => 'Y',
        });

        $query = RekamMedis::with('pasien');

        try {
            if ($jenis === 'bulanan') {
                [$tahun, $bulan] = explode('-', $periode);
                $query->whereYear('tanggal_kunjungan', $tahun)
                      ->whereMonth('tanggal_kunjungan', $bulan);
            } elseif ($jenis === 'mingguan') {
                $start = Carbon::parse($periode)->startOfWeek(Carbon::MONDAY);
                $end = Carbon::parse($periode)->endOfWeek(Carbon::SUNDAY);
                $query->whereBetween('tanggal_kunjungan', [$start, $end]);
            } elseif ($jenis === 'tahunan') {
                $query->whereYear('tanggal_kunjungan', $periode);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Periode tidak valid.');
        }

        return view('laporan.index', [
            'data' => $query->orderBy('tanggal_kunjungan', 'asc')->get(),
            'jenis' => $jenis,
            'periode' => $periode,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $jenis = $request->input('jenis', 'tahunan');
        $periode = $request->input('periode') ?? now()->format(match ($jenis) {
            'tahunan' => 'Y',
            'bulanan' => 'Y-m',
            'mingguan' => 'Y-m-d',
            default => 'Y',
        });

        $query = RekamMedis::with('pasien');
        $namaPeriode = '';

        try {
            if ($jenis === 'bulanan') {
                [$tahun, $bulan] = explode('-', $periode);
                $query->whereYear('tanggal_kunjungan', $tahun)
                      ->whereMonth('tanggal_kunjungan', $bulan);
                $namaPeriode = Carbon::createFromDate($tahun, $bulan)->translatedFormat('F Y');
            } elseif ($jenis === 'mingguan') {
                $start = Carbon::parse($periode)->startOfWeek(Carbon::MONDAY);
                $end = Carbon::parse($periode)->endOfWeek(Carbon::SUNDAY);
                $query->whereBetween('tanggal_kunjungan', [$start, $end]);
                $namaPeriode = 'Minggu ' . $start->translatedFormat('d M') . ' - ' . $end->translatedFormat('d M Y');
            } elseif ($jenis === 'tahunan') {
                $query->whereYear('tanggal_kunjungan', $periode);
                $namaPeriode = 'Tahun ' . $periode;
            } else {
                $namaPeriode = $periode;
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Periode tidak valid.');
        }

        $data = $query->orderBy('tanggal_kunjungan', 'asc')->get();

        $pdf = Pdf::loadView('laporan.pdf', [
            'data' => $data,
            'periode' => $namaPeriode,
            'tanggal_cetak' => now()->translatedFormat('d/m/Y H:i:s'),
        ]);

        $filename = 'Laporan_Keuangan_' . str_replace(' ', '_', $namaPeriode) . '.pdf';
        return $pdf->download($filename);
    }
}
