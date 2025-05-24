@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    {{-- Header Title and Button --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
        <h2 class="text-3xl font-normal text-gray-800 tracking-tight">Laporan Keuangan</h2>
        <a href="{{ route('laporan.export', ['jenis' => request('jenis', 'tahunan'), 'periode' => request('periode', now()->format('Y'))]) }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Download PDF
        </a>
    </div>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('laporan.index') }}" class="grid sm:grid-cols-4 gap-6 items-end bg-gray-50 p-4 rounded-xl shadow-sm">
        <div class="flex flex-col gap-1">
            <label class="block text-sm font-medium text-gray-700">Jenis Laporan</label>
            <select name="jenis" id="jenis" class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200" onchange="updatePeriodeOptions()">
                <option value="mingguan" {{ request('jenis', 'tahunan') == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                <option value="bulanan" {{ request('jenis', 'tahunan') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                <option value="tahunan" {{ request('jenis', 'tahunan') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
            </select>
        </div>
        <div class="flex flex-col gap-1">
            <label class="block text-sm font-medium text-gray-700">Periode</label>
            <select name="periode" id="periode" class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200">
                {{-- Filled via JS --}}
            </select>
        </div>
        <div class="flex flex-col gap-1">
            <span class="invisible">Filter</span>
            <button type="submit"
                    class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition shadow">
                Filter
            </button>
        </div>
        <div class="flex flex-col gap-1">
            <label for="searchLaporanInput" class="block text-sm font-medium text-gray-700">Pencarian</label>
            <input type="text" id="searchLaporanInput" placeholder="Cari pasien / keluhan..."
                   onkeyup="filterLaporanTable()"
                   class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring focus:ring-blue-200 focus:outline-none shadow-sm" />
        </div>
    </form>

    {{-- Statistik --}}
    @if($data->count() > 0)
    <div class="text-sm text-gray-600 mb-2">
        Total Transaksi: <strong>{{ $data->count() }}</strong> |
        Total Pendapatan: <strong>Rp {{ number_format($data->sum('biaya'), 0, ',', '.') }}</strong>
    </div>

    {{-- Tabel Data --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow ring-1 ring-gray-100 mt-4">
        <table class="min-w-full table-auto border-separate border-spacing-y-2 text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider">
                    <th class="px-6 py-3 text-left rounded-tl-lg">Tanggal</th>
                    <th class="px-6 py-3 text-left">Nama Pasien</th>
                    <th class="px-6 py-3 text-left">Keluhan</th>
                    <th class="px-6 py-3 text-right rounded-tr-lg">Biaya</th>
                </tr>
            </thead>
            <tbody id="laporanTable" class="text-gray-800">
                @foreach($data as $rekam)
                <tr class="bg-white hover:bg-blue-50 transition duration-200 shadow-sm">
                    <td class="px-6 py-3">{{ \Carbon\Carbon::parse($rekam->tanggal_kunjungan)->translatedFormat('d F Y') }}</td>
                    <td class="px-6 py-3">{{ $rekam->pasien->nama_pasien }}</td>
                    <td class="px-6 py-3">{{ $rekam->keluhan }}</td>
                    <td class="px-6 py-3 text-right">Rp {{ number_format($rekam->biaya, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center text-gray-500 italic mt-12">Tidak ada data transaksi untuk periode ini.</div>
    @endif
</div>

{{-- JS Section --}}
<script>
function updatePeriodeOptions() {
    const jenis = document.getElementById('jenis').value;
    const periode = document.getElementById('periode');
    const now = new Date();
    const selected = "{{ request('periode', now()->format('Y')) }}";
    periode.innerHTML = '';

    if (jenis === 'tahunan') {
        const currentYear = now.getFullYear();
        for (let i = 0; i < 5; i++) {
            const year = currentYear - i;
            const selectedAttr = (selected == year) ? 'selected' : '';
            periode.innerHTML += `<option value="${year}" ${selectedAttr}>${year}</option>`;
        }
    } else if (jenis === 'bulanan') {
        const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        const year = now.getFullYear();
        for (let i = 0; i < 12; i++) {
            const month = String(i + 1).padStart(2, '0');
            const value = `${year}-${month}`;
            const label = `${months[i]} ${year}`;
            const selectedAttr = (selected == value) ? 'selected' : '';
            periode.innerHTML += `<option value="${value}" ${selectedAttr}>${label}</option>`;
        }
    } else if (jenis === 'mingguan') {
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const base = `${year}-${month}`;
        const weeks = [
            { label: "Minggu 1 (1–7)", value: `${base}-01` },
            { label: "Minggu 2 (8–14)", value: `${base}-08` },
            { label: "Minggu 3 (15–21)", value: `${base}-15` },
            { label: "Minggu 4 (22–31)", value: `${base}-22` }
        ];
        for (const w of weeks) {
            const selectedAttr = (selected == w.value) ? 'selected' : '';
            periode.innerHTML += `<option value="${w.value}" ${selectedAttr}>${w.label}</option>`;
        }
    }
}

function filterLaporanTable() {
    const input = document.getElementById("searchLaporanInput").value.toLowerCase();
    const rows = document.querySelectorAll("#laporanTable tr");
    rows.forEach(row => {
        const nama = row.cells[1].textContent.toLowerCase();
        const keluhan = row.cells[2].textContent.toLowerCase();
        row.style.display = (nama.includes(input) || keluhan.includes(input)) ? "" : "none";
    });
}

document.addEventListener('DOMContentLoaded', updatePeriodeOptions);
</script>
@endsection
