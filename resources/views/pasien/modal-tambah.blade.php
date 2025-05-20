<!-- Modal Tambah Pasien -->
<div id="modalTambah" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden justify-center items-center">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <button type="button" onclick="closeModal()" class="absolute top-2 right-3 text-xl font-bold text-gray-400 hover:text-red-500">×</button>

        <h3 class="text-xl font-semibold mb-4 text-gray-800">Tambah Pasien Baru</h3>

        <form id="formTambah">
            <div class="mb-4">
                <label for="nama_pasien" class="block text-sm font-medium text-gray-700">Nama Pasien:</label>
                <input type="text" name="nama_pasien" id="nama_pasien"
                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>

            <div class="mb-4">
                <label for="tanggal_daftar" class="block text-sm font-medium text-gray-700">Tanggal Daftar:</label>
                <input type="date" name="tanggal_daftar" id="tanggal_daftar" value="{{ date('Y-m-d') }}"
                       class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>

            <div class="mb-4">
                <label for="alamat_pasien" class="block text-sm font-medium text-gray-700">Alamat Pasien:</label>
                <textarea name="alamat_pasien" id="alamat_pasien"
                          class="mt-1 block w-full rounded-md border border-gray-300 p-2 focus:ring-blue-500 focus:border-blue-500"
                          required></textarea>
            </div>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md">
                Simpan
            </button>
        </form>
    </div>
</div>
