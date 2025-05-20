@extends('layouts.app')

@section('content')
    <div class="px-3 sm:px-6 lg:px-8 py-4 sm:py-6">
        {{-- Header Card --}}
        <div
            class="bg-[#446FF2] h-[240px] sm:h-[220px] lg:h-[240px] rounded-xl sm:rounded-2xl relative overflow-hidden text-white shadow-lg px-5 sm:px-6 py-6 sm:py-8 mb-6 sm:mb-8">
            <div class="flex flex-col justify-between h-full relative z-10">
                <div>
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-2">Selamat Datang</h2>
                    <p class="text-xs sm:text-sm lg:text-base opacity-90">Lanjutkan untuk menggunakan seluruh fitur</p>
                </div>
            </div>
            <div class="absolute bottom-3 right-3 sm:bottom-0 sm:right-6">
                <div class="relative w-[100px] sm:w-[140px] lg:w-[180px]">
                    <div
                        class="absolute rounded-full bg-white opacity-20 z-0 w-24 h-24 top-6 left-0 md:w-40 md:h-40 md:top-10 md:left-4">
                    </div>
                    <img src="{{ asset('images/susterDashboard.svg') }}" alt="Suster Dashboard" class="relative z-10 w-full">
                </div>
            </div>
            <div class="absolute bottom-3 left-5 flex gap-1.5 sm:gap-2 z-0">
                <span class="w-3 h-3 sm:w-4 sm:h-4 bg-white opacity-20 rounded-full"></span>
                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-white opacity-20 mt-1.5 sm:mt-2"></span>
            </div>
        </div>

        {{-- Statistik Card --}}
        <h3 class="text-lg font-semibold text-gray-800 mb-4 mt-2">Data Statistik</h3>
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            {{-- Total Pasien --}}
            <div class="bg-white rounded-lg sm:rounded-xl shadow p-4 sm:p-5 lg:p-6 flex flex-col gap-1.5 sm:gap-2">
                <div class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-lg bg-[#446FF2] text-white">
                    <!-- Modern Patient Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <p class="text-xs sm:text-sm text-gray-500">Total Pasien</p>
                <p class="text-base sm:text-lg lg:text-xl font-semibold text-gray-800">{{ $totalPasien }}</p>
            </div>

            {{-- Total Kunjungan --}}
            <div class="bg-white rounded-lg sm:rounded-xl shadow p-4 sm:p-5 lg:p-6 flex flex-col gap-1.5 sm:gap-2">
                <div class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-lg bg-teal-400 text-white">
                    <!-- Modern Visit/Appointment Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                        <path d="M8 14h.01"></path>
                        <path d="M12 14h.01"></path>
                        <path d="M16 14h.01"></path>
                        <path d="M8 18h.01"></path>
                        <path d="M12 18h.01"></path>
                    </svg>
                </div>
                <p class="text-xs sm:text-sm text-gray-500">Total Kunjungan</p>
                <p class="text-base sm:text-lg lg:text-xl font-semibold text-gray-800">{{ $totalKunjungan }}</p>
            </div>

            {{-- Total Pendapatan --}}
            <div class="bg-white rounded-lg sm:rounded-xl shadow p-4 sm:p-5 lg:p-6 flex flex-col gap-1.5 sm:gap-2">
                <div class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-lg bg-yellow-400 text-white">
                    <!-- Modern Money/Revenue Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v20"></path>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <p class="text-xs sm:text-sm text-gray-500">Total Pendapatan</p>
                <p class="text-base sm:text-lg lg:text-xl font-semibold text-gray-800">Rp.
                    {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </div>

            {{-- Pasien Hari Ini --}}
            <div class="bg-white rounded-lg sm:rounded-xl shadow p-4 sm:p-5 lg:p-6 flex flex-col gap-1.5 sm:gap-2">
                <div class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-lg bg-[#446FF2] text-white">
                    <!-- Modern Today's Patients Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 4v4h4"></path>
                        <path d="M17 7L7 17"></path>
                        <path d="M3 11a8 8 0 0 1 14.418-4.885"></path>
                        <path d="M21 12.1a8 8 0 0 1-5.8 7.6"></path>
                        <path d="M9 18a8 8 0 0 1-6-7.714"></path>
                        <circle cx="12" cy="12" r="4"></circle>
                    </svg>
                </div>
                <p class="text-xs sm:text-sm text-gray-500">Pasien Hari Ini</p>
                <p class="text-base sm:text-lg lg:text-xl font-semibold text-gray-800">{{ $totalHariIni }}</p>
            </div>
        </div>
        {{-- TABEL KUNJUNGAN TERBARU --}}
        {{-- Tabel Kunjungan Terbaru --}}
        <div class="mt-6 bg-white rounded-xl shadow p-4 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Kunjungan Terbaru</h3>

            @if ($kunjunganHariIni->isEmpty())
                <p class="text-sm text-gray-500">Belum ada data pasien hari ini.</p>
            @else
                <div class="overflow-x-auto rounded-xl">
                    <table class="min-w-full table-auto border-separate border-spacing-y-2">
                        <thead>
                            <tr class="bg-gray-50 text-gray-700 text-sm uppercase tracking-wider">
                                <th class="px-6 py-3 rounded-tl-xl text-left">Nomor</th>
                                <th class="px-6 py-3 text-left">Nama Pasien</th>
                                <th class="px-6 py-3 text-left">Tanggal Daftar</th>
                                <th class="px-6 py-3 text-left">Alamat</th>
                                <th class="px-6 py-3 rounded-tr-xl text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($kunjunganHariIni as $index => $pasien)
                                <tr class="bg-white hover:bg-blue-50 transition rounded-lg shadow-sm">
                                    <td class="px-6 py-4 font-mono text-gray-500">
                                        {{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-6 py-4">{{ $pasien->nama_pasien }}</td>
                                    <td class="px-6 py-4">
                                        {{ $pasien->created_at ? \Carbon\Carbon::parse($pasien->created_at)->format('d M Y, h:i A') : '-' }}
                                    </td>
                                    <td class="px-6 py-4">{{ $pasien->alamat_pasien }}</td>
                                    <td class="px-6 py-4 text-center space-x-2">
                                        <a href="{{ route('pasien.detail', $pasien->id_pasien) }}"
                                            class="inline-flex items-center px-3 py-1 text-sm text-blue-600 border border-blue-100 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                                            Rekam Medis
                                        </a>

                                        {{-- Edit bisa diarahkan ke /pasien dengan anchor, atau pakai modal --}}
                                        <a href="{{ url('/pasien') }}#edit-{{ $pasien->id_pasien }}"
                                            class="inline-flex items-center px-3 py-1 text-sm text-yellow-600 border border-yellow-200 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                                            Edit
                                        </a>

                                        {{-- Form Delete --}}
                                        <form action="{{ url('/pasien/' . $pasien->id_pasien) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Yakin ingin menghapus pasien ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 text-sm text-red-600 border border-red-200 bg-red-50 rounded-lg hover:bg-red-100 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
@endsection
