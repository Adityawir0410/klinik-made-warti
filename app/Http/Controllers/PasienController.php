<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;

class PasienController extends Controller
{
    /**
     * Tampilkan semua data pasien.
     */
    public function index(Request $request)
    {
        $query = $request->input('search');

        $pasien = \App\Models\Pasien::when($query, function ($q) use ($query) {
            $q->where('nama_pasien', 'like', '%' . $query . '%');
        })->get();

        return view('pasien.index', compact('pasien', 'query'));
    }


    /**
     * 
     * Tampilkan detail rekam medis untuk 1 pasien.
     */
    public function show($id)
    {
        $pasien = Pasien::with('rekamMedis')->findOrFail($id);
        return view('pasien.detail', compact('pasien'));
    }

    public function create()
    {
        return view('pasien.create'); // tampilkan form input pasien
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required',
            'alamat_pasien' => 'required',
            'tanggal_daftar' => 'required|date',
        ]);

        $pasien = new Pasien();
        $pasien->nama_pasien = $request->nama_pasien;
        $pasien->alamat_pasien = $request->alamat_pasien;
        $pasien->created_at = $request->tanggal_daftar;
        $pasien->save();

        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil ditambahkan!');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pasien' => 'required',
            'alamat_pasien' => 'required',
            'tanggal_daftar' => 'required|date',
        ]);

        $pasien = Pasien::findOrFail($id);
        $pasien->nama_pasien = $request->nama_pasien;
        $pasien->alamat_pasien = $request->alamat_pasien;
        $pasien->created_at = $request->tanggal_daftar; // penting!
        $pasien->save();

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus.');
    }
}
