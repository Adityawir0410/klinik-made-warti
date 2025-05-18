<h2>Rekam Medis: {{ $pasien->nama_pasien }}</h2>

<!-- Notifikasi -->
@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<!-- Tombol Tambah -->
<p>
    <button onclick="openTambahModal()">+ Tambah Rekam Medis</button>
</p>

<!-- Modal Tambah Rekam Medis -->
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeTambahModal()">&times;</span>
        <h3>Tambah Rekam Medis</h3>
        <form action="{{ route('rekam.store', $pasien->id_pasien) }}" method="POST">
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

<!-- Modal Edit Rekam Medis -->
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h3>Edit Rekam Medis</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
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
<table border="1" cellpadding="10">
    <tr>
        <th>Tanggal</th>
        <th>Keluhan</th>
        <th>Biaya</th>
        <th>Aksi</th>
    </tr>
    @foreach ($pasien->rekamMedis as $rekam)
        <tr>
            <td>{{ $rekam->tanggal_kunjungan }}</td>
            <td>{{ $rekam->keluhan }}</td>
            <td>{{ number_format($rekam->biaya) }}</td>
            <td>
                <button onclick="openEditModal(
                    '{{ $rekam->id_rekam }}',
                    '{{ $rekam->tanggal_kunjungan }}',
                    @js($rekam->keluhan),
                    '{{ $rekam->biaya }}'
                )">Edit</button> |
                <form action="{{ route('rekam.destroy', $rekam->id_rekam) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus data?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

<!-- Script Modal -->
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 999;
        left: 0; top: 0;
        width: 100%; height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background: white;
        margin: 10% auto;
        padding: 20px;
        width: 400px;
        border-radius: 8px;
        position: relative;
    }

    .close {
        position: absolute;
        top: 5px;
        right: 10px;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }
</style>

<script>
    function openTambahModal() {
        history.replaceState(null, null, location.href); // cegah back 2x
        document.getElementById("modalTambah").style.display = "block";
    }

    function closeTambahModal() {
        document.getElementById("modalTambah").style.display = "none";
    }

    function openEditModal(id, tanggal, keluhan, biaya) {
        history.replaceState(null, null, location.href); // cegah back 2x
        document.getElementById("editTanggal").value = tanggal;
        document.getElementById("editKeluhan").value = keluhan;
        document.getElementById("editBiaya").value = biaya;
        document.getElementById("editForm").action = "/rekam-medis/" + id;
        document.getElementById("modalEdit").style.display = "block";
    }

    function closeEditModal() {
        document.getElementById("modalEdit").style.display = "none";
    }
</script>
