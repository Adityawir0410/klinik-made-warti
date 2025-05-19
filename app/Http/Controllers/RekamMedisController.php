<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    /**
     * Simpan data rekam medis baru (AJAX).
     */
    public function store(Request $request, $id_pasien)
    {
        try {
            $request->validate([
                'tanggal_kunjungan' => 'required|date',
                'keluhan' => 'required|string',
                'biaya' => 'required|numeric',
            ]);

            $rekam = RekamMedis::create([
                'id_rekam' => substr(uniqid('R'), 0, 10), // pastikan <= 10 char
                'id_pasien' => $id_pasien,
                'user_id' => Auth::check() ? Auth::id() : 1, // fallback ke user id 1 jika belum login
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'keluhan' => $request->keluhan,
                'biaya' => $request->biaya,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data rekam medis berhasil ditambahkan.',
                'rekam' => $rekam
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Perbarui data rekam medis (AJAX).
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'tanggal_kunjungan' => 'required|date',
                'keluhan' => 'required|string',
                'biaya' => 'required|numeric',
            ]);

            $rekam = RekamMedis::findOrFail($id);
            $rekam->update([
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'keluhan' => $request->keluhan,
                'biaya' => $request->biaya,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui.',
                'rekam' => $rekam
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus data rekam medis (AJAX).
     */
    public function destroy($id)
{
    try {
        $rekam = RekamMedis::findOrFail($id);
        $rekam->delete();

        return response()->json(['success' => true, 'message' => 'Berhasil dihapus.']);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}

}
