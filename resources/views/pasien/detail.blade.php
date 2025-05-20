@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
        <h2 class="text-3xl font-normal text-gray-800 tracking-tight">Rekam Medis: {{ $pasien->nama_pasien }}</h2>
        <button onclick="openTambahModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 shadow-sm transition mt-2 sm:mt-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Data</span>
        </button>
    </div>

    {{-- Notifikasi --}}
    <div id="notifArea"></div>

    {{-- Tabel Rekam Medis --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
        <table class="min-w-full table-auto border-separate border-spacing-y-2">
            <thead>
                <tr class="bg-[#F7F7F7] text-gray-700 uppercase text-xs tracking-wider">
                    <th class="px-6 py-3 rounded-tl-xl">Tanggal</th>
                    <th class="px-6 py-3">Keluhan</th>
                    <th class="px-6 py-3">Biaya</th>
                    <th class="px-6 py-3 rounded-tr-xl text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700" id="rekamTable" data-pasien="{{ $pasien->id_pasien }}">
                @foreach ($pasien->rekamMedis as $rekam)
                <tr id="row-{{ $rekam->id_rekam }}" class="bg-white hover:bg-blue-50 transition rounded-lg shadow-sm">
                    <td class="px-6 py-4 text-sm">{{ $rekam->tanggal_kunjungan }}</td>
                    <td class="px-6 py-4 text-sm">{{ $rekam->keluhan }}</td>
                    <td class="px-6 py-4 text-sm">Rp{{ number_format($rekam->biaya, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <button onclick="openEditModal('{{ $rekam->id_rekam }}', '{{ $rekam->tanggal_kunjungan }}', @js($rekam->keluhan), '{{ $rekam->biaya }}')"
                            class="inline-flex items-center px-3 py-1 text-sm text-yellow-700 border border-yellow-100 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                            Edit
                        </button>
                        <button onclick="hapusRekam('{{ $rekam->id_rekam }}')"
                            class="inline-flex items-center px-3 py-1 text-sm text-red-600 border border-red-100 bg-red-50 rounded-lg hover:bg-red-100 transition">
                            Hapus
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah --}}
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeTambahModal()">&times;</span>
        <h3 class="text-lg font-semibold mb-4">Tambah Rekam Medis</h3>
        <form id="formTambah">
            @csrf
            <label class="block mb-1">Tanggal Kunjungan:</label>
            <input type="date" name="tanggal_kunjungan" class="w-full border rounded px-3 py-2 mb-3" required>

            <label class="block mb-1">Keluhan:</label>
            <textarea name="keluhan" class="w-full border rounded px-3 py-2 mb-3" required></textarea>

            <label class="block mb-1">Biaya:</label>
            <input type="number" name="biaya" class="w-full border rounded px-3 py-2 mb-3" required>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeTambahModal()" class="border border-blue-500 text-blue-600 px-4 py-2 rounded hover:bg-blue-50 transition">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h3 class="text-lg font-semibold mb-4">Edit Rekam Medis</h3>
        <form id="formEdit">
            @csrf
            @method('PUT')
            <input type="hidden" name="id_rekam" id="editId">

            <label class="block mb-1">Tanggal Kunjungan:</label>
            <input type="date" name="tanggal_kunjungan" id="editTanggal" class="w-full border rounded px-3 py-2 mb-3" required>

            <label class="block mb-1">Keluhan:</label>
            <textarea name="keluhan" id="editKeluhan" class="w-full border rounded px-3 py-2 mb-3" required></textarea>

            <label class="block mb-1">Biaya:</label>
            <input type="number" name="biaya" id="editBiaya" class="w-full border rounded px-3 py-2 mb-3" required>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeEditModal()" class="border border-blue-500 text-blue-600 px-4 py-2 rounded hover:bg-blue-50 transition">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Styling --}}
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }
    .modal-content {
        background-color: white;
        margin: 7% auto 0 auto;
        padding: 24px 24px 20px 24px;
        width: 95%;
        max-width: 480px;
        border-radius: 14px;
        position: relative;
        box-shadow: 0 8px 32px rgba(0,0,0,0.13);
    }
    .close {
        position: absolute;
        top: 10px;
        right: 16px;
        font-size: 22px;
        font-weight: bold;
        color: #888;
        cursor: pointer;
        transition: color 0.2s;
    }
    .close:hover {
        color: #446FF2;
    }
</style>

{{-- Script --}}
<script>
    window.pasienId = @json($pasien->id_pasien);
</script>

@vite('resources/js/pasien/detail.js')
@endsection
