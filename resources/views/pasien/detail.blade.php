<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rekam Medis Pasien</title>
    <style>
        .modal {
            display: none; position: fixed; z-index: 999; left: 0; top: 0;
            width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background: white; margin: 10% auto; padding: 20px;
            width: 400px; border-radius: 8px; position: relative;
        }
        .close {
            position: absolute; top: 5px; right: 10px;
            font-size: 20px; font-weight: bold; cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Rekam Medis: {{ $pasien->nama_pasien }}</h2>

<!-- Notifikasi -->
<div id="notifArea"></div>

<!-- Tombol Tambah -->
<p><button onclick="openTambahModal()">+ Tambah Rekam Medis</button></p>

<!-- Modal Tambah -->
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeTambahModal()">&times;</span>
        <h3>Tambah Rekam Medis</h3>
        <form id="formTambah">
            @csrf
            <label>Tanggal Kunjungan:</label><br>
            <input type="date" name="tanggal_kunjungan" required><br><br>
            <label>Keluhan:</label><br>
            <textarea name="keluhan" required></textarea><br><br>
            <label>Biaya:</label><br>
            <input type="number" name="biaya" required><br><br>
            <button type="submit">Simpan</button>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h3>Edit Rekam Medis</h3>
        <form id="formEdit">
            @csrf
            @method('PUT')
            <input type="hidden" name="id_rekam" id="editId">
            <label>Tanggal Kunjungan:</label><br>
            <input type="date" name="tanggal_kunjungan" id="editTanggal" required><br><br>
            <label>Keluhan:</label><br>
            <textarea name="keluhan" id="editKeluhan" required></textarea><br><br>
            <label>Biaya:</label><br>
            <input type="number" name="biaya" id="editBiaya" required><br><br>
            <button type="submit">Update</button>
        </form>
    </div>
</div>

<!-- Tabel Rekam Medis -->
<table border="1" cellpadding="10" id="tabelRekam" data-pasien="{{ $pasien->id_pasien }}">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Keluhan</th>
            <th>Biaya</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pasien->rekamMedis as $rekam)
        <tr id="row-{{ $rekam->id_rekam }}">
            <td>{{ $rekam->tanggal_kunjungan }}</td>
            <td>{{ $rekam->keluhan }}</td>
            <td>{{ number_format($rekam->biaya) }}</td>
            <td>
                <button onclick="openEditModal('{{ $rekam->id_rekam }}', '{{ $rekam->tanggal_kunjungan }}', @js($rekam->keluhan), '{{ $rekam->biaya }}')">Edit</button> |
                <button onclick="hapusRekam('{{ $rekam->id_rekam }}')">Hapus</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    window.pasienId = @json($pasien->id_pasien); // dikirim ke JS global
</script>
@vite('resources/js/pasien/detail.js')

</body>
</html>
