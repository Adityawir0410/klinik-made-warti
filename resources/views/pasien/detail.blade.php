@extends('layouts.app')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8 py-6">

        {{-- Judul Halaman --}}
        <h2 class="text-3xl font-normal text-gray-800 tracking-tight mb-8">Rekam Medis</h2>

        {{-- Info Pasien & Tombol --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div class="flex items-center space-x-6">
                {{-- Icon Profil --}}
                <div class="w-16 h-16 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2V19.2c0-3.2-6.4-4.8-9.6-4.8z" />
                    </svg>
                </div>
                {{-- Nama & Alamat Pasien --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $pasien->nama_pasien }}</h3>
                    <p class="text-sm text-gray-600">
                        {{ $pasien->alamat_pasien ?? $pasien->alamat ?? '-' }}
                    </p>
                </div>
            </div>
            <button onclick="openTambahModal()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 shadow-sm transition mt-4 sm:mt-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Data</span>
            </button>
        </div>

        <div id="notifArea"></div>

        {{-- Search Bar --}}
        <div class="flex w-full mb-6">
            <input type="text" id="searchRekamInput" placeholder="Cari keluhan atau tanggal kunjungan..." onkeyup="filterRekamTable()"
                class="flex-1 px-4 py-2 border border-blue-300 rounded-lg focus:ring focus:ring-blue-100 focus:outline-none shadow-sm" />
        </div>

        <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
            <table class="min-w-full table-auto border-separate border-spacing-y-2">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider">
                        <th class="px-6 py-3 rounded-tl-xl">Tanggal</th>
                        <th class="px-6 py-3">Keluhan</th>
                        <th class="px-6 py-3">Biaya</th>
                        <th class="px-6 py-3 rounded-tr-xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700" id="rekamTable" data-pasien="{{ $pasien->id_pasien }}">
                    @foreach ($pasien->rekamMedis as $rekam)
                        <tr id="row-{{ $rekam->id_rekam }}"
                            class="bg-white hover:bg-blue-50 transition rounded-lg shadow-sm">
                            <td class="px-6 py-4 text-sm">{{ $rekam->tanggal_kunjungan }}</td>
                            <td class="px-6 py-4 text-sm">{{ $rekam->keluhan }}</td>
                            <td class="px-6 py-4 text-sm">Rp{{ number_format($rekam->biaya, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <button
                                    onclick="openEditModal('{{ $rekam->id_rekam }}', '{{ $rekam->tanggal_kunjungan }}', @js($rekam->keluhan), '{{ $rekam->biaya }}')"
                                    class="inline-flex items-center px-3 py-1 text-sm text-yellow-600 border border-yellow-200 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                                    <!-- Edit Icon -->
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a4 4 0 01-2.828 1.172H7v-2a4 4 0 011.172-2.828z" />
                                    </svg>
                                    Edit
                                </button>
                                <button onclick="openDeleteModal('{{ $rekam->id_rekam }}')"
                                    class="inline-flex items-center px-3 py-1 text-sm text-red-600 border border-red-200 bg-red-50 rounded-lg hover:bg-red-100 transition">
                                    <!-- Trash Icon -->
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 7h12M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m2 0v12a2 2 0 01-2 2H8a2 2 0 01-2-2V7h12z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6M14 11v6" />
                                    </svg>
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ====== MODAL TAMBAH ====== --}}
    <div id="modalTambah" class="modal">
        <div class="modal-content" style="margin-top: 120px;">
            <span class="close" onclick="closeTambahModal()">&times;</span>
            <h3 class="text-xl font-bold mb-6">Tambah Rekam Medis</h3>
            <form id="formTambah" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-semibold text-sm text-gray-700 mb-1">Tanggal Kunjungan</label>
                    <input type="date" name="tanggal_kunjungan"
                        class="w-full rounded-lg border border-blue-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required>
                </div>
                <div>
                    <label class="block font-semibold text-sm text-gray-700 mb-1">Keluhan</label>
                    <textarea name="keluhan"
                        class="w-full rounded-lg border border-blue-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required></textarea>
                </div>
                <div>
                    <label class="block font-semibold text-sm text-gray-700 mb-1">Biaya</label>
                    <input type="number" name="biaya"
                        class="w-full rounded-lg border border-blue-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required>
                </div>
                <div class="flex justify-end space-x-3 pt-3">
                    <button type="button" onclick="closeTambahModal()"
                        class="border border-blue-500 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50">Batal</button>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ====== MODAL EDIT ====== --}}
    <div id="modalEdit" class="modal">
        <div class="modal-content" style="margin-top: 120px;">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h3 class="text-xl font-bold mb-6">Edit Rekam Medis</h3>
            <form id="formEdit" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_rekam" id="editId">
                <div>
                    <label class="block font-semibold text-sm text-gray-700 mb-1">Tanggal Kunjungan</label>
                    <input type="date" name="tanggal_kunjungan" id="editTanggal"
                        class="w-full rounded-lg border border-blue-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required>
                </div>
                <div>
                    <label class="block font-semibold text-sm text-gray-700 mb-1">Keluhan</label>
                    <textarea name="keluhan" id="editKeluhan"
                        class="w-full rounded-lg border border-blue-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required></textarea>
                </div>
                <div>
                    <label class="block font-semibold text-sm text-gray-700 mb-1">Biaya</label>
                    <input type="number" name="biaya" id="editBiaya"
                        class="w-full rounded-lg border border-blue-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required>
                </div>
                <div class="flex justify-end space-x-3 pt-3">
                    <button type="button" onclick="closeEditModal()"
                        class="border border-blue-500 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ====== MODAL DELETE ====== --}}
    <div id="modalDelete" class="modal">
        <div class="modal-content text-center" style="margin-top: 120px;">
            <div class="flex justify-center mb-4">
                <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-500">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="11" fill="none" />
                        <path d="M12 8v4m0 4h.01" stroke="#fff" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <circle cx="12" cy="16" r="1" fill="#fff" />
                    </svg>
                </span>
            </div>
            <h3 class="text-lg font-semibold mb-2">Apa kamu yakin untuk menghapus data?</h3>
            <p class="text-gray-600 mb-6">Data rekam medis ini akan dihapus secara permanen.</p>
            <div class="flex justify-center gap-4">
                <button onclick="closeDeleteModal()"
                    class="px-4 py-2 border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-50">Kembali</button>
                <form id="formDelete" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus
                        Data</button>
                </form>
            </div>
        </div>
    </div>

    {{-- ====== MODAL STYLING ====== --}}
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 8% auto;
            padding: 24px;
            border-radius: 14px;
            max-width: 480px;
            width: 90%;
            position: relative;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 16px;
            font-size: 22px;
            font-weight: bold;
            color: #888;
            cursor: pointer;
        }

        .close:hover {
            color: #446FF2;
        }
    </style>

    {{-- ====== SCRIPT ====== --}}
    <script>
        window.pasienId = @json($pasien->id_pasien);

        function openDeleteModal(id) {
            const form = document.getElementById("formDelete");
            form.action = `/rekam-medis/${id}`;
            document.getElementById("modalDelete").style.display = "block";
        }

        function closeDeleteModal() {
            document.getElementById("modalDelete").style.display = "none";
        }

        function filterRekamTable() {
            const input = document.getElementById("searchRekamInput").value.toLowerCase();
            const rows = document.querySelectorAll("#rekamTable tr");
            rows.forEach(row => {
                const tanggal = row.cells[0].textContent.toLowerCase();
                const keluhan = row.cells[1].textContent.toLowerCase();
                row.style.display = (tanggal.includes(input) || keluhan.includes(input)) ? "" : "none";
            });
        }
    </script>

    @vite('resources/js/pasien/detail.js')
@endsection
