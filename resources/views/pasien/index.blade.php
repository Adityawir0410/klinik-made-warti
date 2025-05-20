@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
        <h2 class="text-3xl font-normal text-gray-800 tracking-tight">Data Pasien</h2>
        <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 shadow-sm transition mt-2 sm:mt-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Data</span>
        </button>
    </div>

    <div class="flex w-full mb-6">
        <input type="text" id="searchInput" placeholder="Cari Nama Pasien..." onkeyup="filterTable()"
            class="flex-1 px-4 py-2 border border-blue-300 rounded-lg focus:ring focus:ring-blue-100 focus:outline-none shadow-sm" />
    </div>

    <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
        <table class="min-w-full table-auto border-separate border-spacing-y-2">
            <thead>
                <tr class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider">
                    <th class="px-6 py-3 rounded-tl-xl">No</th>
                    <th class="px-6 py-3">Nama Pasien</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Alamat</th>
                    <th class="px-6 py-3 rounded-tr-xl text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="pasienTable" class="text-gray-700">
                @foreach ($pasien as $index => $p)
                <tr class="bg-white hover:bg-blue-50 transition rounded-lg shadow-sm">
                    <td class="px-6 py-4 text-center font-semibold text-gray-500">{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4">{{ $p->nama_pasien }}</td>
                    <td class="px-6 py-4">{{ $p->created_at ? $p->created_at->format('d-m-Y') : '-' }}</td>
                    <td class="px-6 py-4">{{ $p->alamat_pasien }}</td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('pasien.detail', $p->id_pasien) }}"
                           class="inline-flex items-center px-3 py-1 text-sm text-blue-600 border border-blue-100 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                            </svg>
                            Rekam Medis
                        </a>
                        <button onclick="openEditModal('{{ $p->id_pasien }}', '{{ $p->nama_pasien }}', '{{ $p->created_at ? $p->created_at->format('Y-m-d') : '' }}', `{{ $p->alamat_pasien }}`)"
                            class="inline-flex items-center px-3 py-1 text-sm text-yellow-600 border border-yellow-200 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                            <!-- Edit Icon -->
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a4 4 0 01-2.828 1.172H7v-2a4 4 0 011.172-2.828z"/>
                            </svg>
                            Edit
                        </button>
                        <button onclick="openDeleteModal('{{ $p->id_pasien }}')"
                            class="inline-flex items-center px-3 py-1 text-sm text-red-600 border border-red-200 bg-red-50 rounded-lg hover:bg-red-100 transition">
                            <!-- Trash Icon -->
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m2 0v12a2 2 0 01-2 2H8a2 2 0 01-2-2V7h12z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6M14 11v6"/>
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
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3 class="text-xl font-bold mb-6">Tambah Data Pasien</h3>
        <form id="formTambah" class="space-y-4">
            <div>
                <label class="block font-semibold text-sm text-gray-700 mb-1">Nama Pasien</label>
                <input type="text" name="nama_pasien" placeholder="Masukkan nama lengkap pasien" class="w-full rounded-lg border border-blue-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
            </div>
            <div>
                <label class="block font-semibold text-sm text-gray-700 mb-1">Tanggal Daftar</label>
                <input type="date" name="tanggal_daftar" value="{{ date('Y-m-d') }}" class="w-full rounded-lg border border-blue-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
            </div>
            <div>
                <label class="block font-semibold text-sm text-gray-700 mb-1">Alamat Pasien</label>
                <textarea name="alamat_pasien" placeholder="Masukkan alamat pasien" class="w-full rounded-lg border border-blue-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required></textarea>
            </div>
            <div class="flex justify-end space-x-3 pt-3">
                <button type="button" onclick="closeModal()" class="border border-blue-500 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ====== MODAL EDIT ====== --}}
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h3 class="text-xl font-bold mb-6">Edit Data Pasien</h3>
        <form id="formEdit" class="space-y-4">
            <input type="hidden" id="editId">
            <div>
                <label class="block font-semibold text-sm text-gray-700 mb-1">Nama Pasien</label>
                <input type="text" name="nama_pasien" id="editNamaPasien" class="w-full rounded-lg border border-blue-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
            </div>
            <div>
                <label class="block font-semibold text-sm text-gray-700 mb-1">Tanggal Daftar</label>
                <input type="date" name="tanggal_daftar" id="editTanggalDaftar" class="w-full rounded-lg border border-blue-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required>
            </div>
            <div>
                <label class="block font-semibold text-sm text-gray-700 mb-1">Alamat Pasien</label>
                <textarea name="alamat_pasien" id="editAlamatPasien" class="w-full rounded-lg border border-blue-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300" required></textarea>
            </div>
            <div class="flex justify-end space-x-3 pt-3">
                <button type="button" onclick="closeEditModal()" class="border border-blue-500 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- ====== MODAL HAPUS ====== --}}
<div id="modalDelete" class="modal">
    <div class="modal-content text-center">
        <div class="flex justify-center mb-4">
            <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-500">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="11" fill="none"/>
                    <path d="M12 8v4m0 4h.01" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="16" r="1" fill="#fff"/>
                </svg>
            </span>
        </div>
        <h3 class="text-lg font-semibold mb-2">Apa kamu yakin untuk menghapus data?</h3>
        <p class="text-gray-600 mb-6">Dengan menghapus data pasien, anda akan kehilangan data tersebut secara permanen.</p>
        <div class="flex justify-center gap-4">
            <button onclick="closeDeleteModal()" class="px-4 py-2 border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-50">Kembali</button>
            <form id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus Data</button>
            </form>
        </div>
    </div>
</div>

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

<script>
    function filterTable() {
        const input = document.getElementById("searchInput").value.toLowerCase();
        const rows = document.querySelectorAll("#pasienTable tr");
        rows.forEach(row => {
            const nama = row.cells[1].textContent.toLowerCase();
            row.style.display = nama.includes(input) ? "" : "none";
        });
    }

    function openModal() {
        document.getElementById("modal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("modal").style.display = "none";
    }

    function openEditModal(id, nama, tanggal, alamat) {
        document.getElementById("editId").value = id;
        document.getElementById("editNamaPasien").value = nama;
        document.getElementById("editTanggalDaftar").value = tanggal;
        document.getElementById("editAlamatPasien").value = alamat;
        document.getElementById("modalEdit").style.display = "block";
    }

    function closeEditModal() {
        document.getElementById("modalEdit").style.display = "none";
    }

    function openDeleteModal(id) {
        const form = document.getElementById("formDelete");
        form.action = `/pasien/${id}`;
        document.getElementById("modalDelete").style.display = "block";
    }

    function closeDeleteModal() {
        document.getElementById("modalDelete").style.display = "none";
    }
</script>

@vite('resources/js/pasien/index.js')
@endsection
