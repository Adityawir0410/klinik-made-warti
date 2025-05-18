<!-- resources/views/pasien/create.blade.php -->

<h2>Tambah Pasien Baru</h2>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('pasien.store') }}" method="POST">
    @csrf

    <label>Nama Pasien:</label><br>
    <input type="text" name="nama_pasien"><br><br>

    <label>Tanggal Daftar:</label><br>
    <input type="date" name="tanggal_daftar" value="{{ date('Y-m-d') }}"><br><br>

    <label>Alamat Pasien:</label><br>
    <textarea name="alamat_pasien"></textarea><br><br>

    <button type="submit">Simpan</button>
</form>
