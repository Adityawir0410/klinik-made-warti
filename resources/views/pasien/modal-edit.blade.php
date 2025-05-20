<!-- Modal Edit Pasien -->
<div id="modalEdit" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg shadow-md w-full max-w-md p-6 relative">
        <button onclick="closeEditModal()" class="absolute top-2 right-3 text-xl font-bold text-gray-500 hover:text-red-500">×</button>

        <h3 class="text-xl font-semibold mb-4 text-gray-800">Edit Data Pasien</h3>

        <form id="formEdit">
            <input type="hidden" id="editId">

            <div class="mb-4">
                <label for="editNamaPasien" class="block text-sm font-medium text-gray-700">Nama Pasien:</label>
                <input type="text" name="nama_pasien" id="editNamaPasien"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                       required>
            </div>

            <div class="mb-4">
                <label for="editTanggalDaftar" class="block text-sm font-medium text-gray-700">Tanggal Daftar:</label>
                <input type="date" name="tanggal_daftar" id="editTanggalDaftar"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                       required>
            </div>

            <div class="mb-4">
                <label for="editAlamatPasien" class="block text-sm font-medium text-gray-700">Alamat Pasien:</label>
                <textarea name="alamat_pasien" id="editAlamatPasien"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                          required></textarea>
            </div>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
