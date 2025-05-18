<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    /**
     * Simpan data rekam medis baru.
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
            'id_rekam' => substr(uniqid('R'), 0, 10), // jaga panjang maksimal
            'id_pasien' => $id_pasien,
            'user_id' => Auth::user()?->id ?? 1,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'keluhan' => $request->keluhan,
            'biaya' => $request->biaya,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'rekam' => $rekam]);
        }

        return back()->with('success', 'Rekam medis berhasil ditambahkan!');
    } catch (\Exception $e) {
        return $request->ajax()
            ? response()->json(['success' => false, 'error' => $e->getMessage()])
            : back()->with('error', 'Gagal menyimpan data');
    }
}


    /**
     * Perbarui data rekam medis.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_kunjungan' => 'required|date',
            'keluhan' => 'required|string',
            'biaya' => 'required|numeric',
        ]);

        try {
            $rekam = RekamMedis::findOrFail($id);
            $rekam->update([
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'keluhan' => $request->keluhan,
                'biaya' => $request->biaya,
            ]);

            return back()->with('success', 'Rekam medis berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withErrors(['Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    /**
     * Hapus data rekam medis.
     */
    public function destroy($id)
    {
        try {
            $rekam = RekamMedis::findOrFail($id);
            $rekam->delete();

            return back()->with('success', 'Rekam medis berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}
