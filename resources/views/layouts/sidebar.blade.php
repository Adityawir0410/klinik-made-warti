<aside id="sidebar" class="
    fixed top-[80px] left-0 z-40 w-64 h-screen bg-white border-r border-gray-200 
    transform -translate-x-full transition-transform duration-300 
    md:translate-x-0
">
    <nav class="mt-6 space-y-1 px-4">
        <a href="{{ route('dashboard.booking') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-blue-50 
           {{ request()->routeIs('dashboard.booking') ? 'bg-blue-100 text-blue-600 font-medium' : 'text-gray-500' }}">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="..." /> <!-- Ganti dengan path ikon Booking -->
            </svg>
            <span>Booking</span>
        </a>

        <a href="{{ route('pasien.index') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-blue-50 
           {{ request()->routeIs('pasien.index') ? 'bg-blue-100 text-blue-600 font-medium' : 'text-gray-500' }}">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="..." /> <!-- Ganti dengan path ikon Pasien -->
            </svg>
            <span>Data Pasien</span>
        </a>

        <a href="{{ route('laporan.index') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-blue-50 
           {{ request()->routeIs('laporan.index') ? 'bg-blue-100 text-blue-600 font-medium' : 'text-gray-500' }}">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="..." /> <!-- Ganti dengan path ikon Laporan -->
            </svg>
            <span>Laporan</span>
        </a>
    </nav>

    <div class="px-4 pb-6 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-500 hover:bg-red-50 hover:text-red-600 rounded-md">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="..." /> <!-- Ganti dengan path ikon Logout -->
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
