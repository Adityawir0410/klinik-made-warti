<!DOCTYPE html>
<html>
<head>
    <title>Data Pasien</title>
    <style>
        /* Modal styling */
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
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            width: 400px;
            border-radius: 8px;
            position: relative;
        }

        .close {
            position: absolute;
            right: 10px;
            top: 5px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Daftar Pasien</h1>

    <!-- Tombol Tambah -->
    <p>
        <button onclick="openModal()">+ Tambah Pasien</button>
    </p>

    <!-- Search Bar -->
    <input type="text" id="searchInput" placeholder="Cari Nama Pasien..." onkeyup="filterTable()" style="margin-bottom: 10px; padding: 5px; width: 250px;">

    <!-- Modal Tambah -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Tambah Pasien Baru</h3>

            <form action="{{ route('pasien.store') }}" method="POST">
                @csrf
                <label>Nama Pasien:</label><br>
                <input type="text" name="nama_pasien" required><br><br>

                <label>Tanggal Daftar:</label><br>
                <input type="date" name="tanggal_daftar" value="{{ date('Y-m-d') }}" required><br><br>

                <label>Alamat Pasien:</label><br>
                <textarea name="alamat_pasien" required></textarea><br><br>

                <button type="submit">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h3>Edit Data Pasien</h3>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <label>Nama Pasien:</label><br>
                <input type="text" name="nama_pasien" id="editNamaPasien" required><br><br>

                <label>Tanggal Daftar:</label><br>
                <input type="date" name="tanggal_daftar" id="editTanggalDaftar" required><br><br>

                <label>Alamat Pasien:</label><br>
                <textarea name="alamat_pasien" id="editAlamatPasien" required></textarea><br><br>

                <button type="submit">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <!-- Tabel Pasien -->
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>Tanggal Daftar</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="pasienTable">
            @foreach ($pasien as $index => $p)
                <tr>
                    <td>{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $p->nama_pasien }}</td>
                    <td>{{ $p->created_at ? $p->created_at->format('d-m-Y') : '-' }}</td>
                    <td>{{ $p->alamat_pasien }}</td>
                    <td>
                        <a href="{{ route('pasien.detail', $p->id_pasien) }}">Lihat Rekam Medis</a> |
                        <button onclick="openEditModal(
                            '{{ $p->id_pasien }}',
                            '{{ $p->nama_pasien }}',
                            '{{ $p->created_at ? $p->created_at->format('Y-m-d') : '' }}',
                            '{{ $p->alamat_pasien }}'
                        )">Edit</button> |
                        <form action="{{ route('pasien.destroy', $p->id_pasien) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pasien ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Script -->
    <script>
        function openModal() {
            document.getElementById("modal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("modal").style.display = "none";
        }

        function openEditModal(id, nama, tanggal, alamat) {
            document.getElementById("editNamaPasien").value = nama;
            document.getElementById("editTanggalDaftar").value = tanggal;
            document.getElementById("editAlamatPasien").value = alamat;
            document.getElementById("editForm").action = `/pasien/${id}`;
            document.getElementById("editModal").style.display = "block";
        }

        function closeEditModal() {
            document.getElementById("editModal").style.display = "none";
        }

        function filterTable() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const rows = document.querySelectorAll("#pasienTable tr");

            rows.forEach(row => {
                const nama = row.cells[1].textContent.toLowerCase();
                row.style.display = nama.includes(input) ? "" : "none";
            });
        }
    </script>
</body>
</html>
