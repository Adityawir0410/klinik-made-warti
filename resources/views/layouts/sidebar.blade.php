<aside id="sidebar" class="
    fixed top-[80px] left-0 z-40 w-64 h-screen bg-white border-r border-gray-200 
    transform -translate-x-full transition-transform duration-300 
    md:translate-x-0
">
    <nav class="mt-6 space-y-1 px-4">
        <a href="{{ route('dashboard.booking') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-blue-50 
           {{ request()->routeIs('dashboard.booking') ? 'bg-blue-100 text-blue-600 font-medium' : 'text-gray-500' }}">
            <!-- Booking Icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
            <span>Booking</span>
        </a>

        <a href="{{ route('pasien.index') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-blue-50 
           {{ request()->routeIs('pasien.index') ? 'bg-blue-100 text-blue-600 font-medium' : 'text-gray-500' }}">
            <!-- Pasien Icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 20v-1a4 4 0 014-4h8a4 4 0 014 4v1"/>
            </svg>
            <span>Data Pasien</span>
        </a>

        <a href="{{ route('laporan.index') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-blue-50 
           {{ request()->routeIs('laporan.index') ? 'bg-blue-100 text-blue-600 font-medium' : 'text-gray-500' }}">
            <!-- Laporan Icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="4" y="4" width="16" height="16" rx="2"/>
                <path d="M8 9h8M8 13h6M8 17h4"/>
            </svg>
            <span>Laporan</span>
        </a>
    </nav>

    <div class="px-4 pb-6 mt-8">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full flex items-center gap-3 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md">
                <!-- Logout Icon -->
                <svg class="w-5 h-5" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                    <path d="M3 21V3"/>
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
