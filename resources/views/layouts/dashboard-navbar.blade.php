<nav class="fixed top-0 left-0 w-full h-[80px] bg-white border-b border-gray-200 shadow-md shadow-gray-100 z-50">
    <div class="relative h-full flex items-center justify-between px-4 md:px-10">

        {{-- Kiri: Toggle + Judul --}}
        <div class="flex items-center space-x-4">
            {{-- Tombol toggle sidebar (mobile) --}}
            <button id="sidebarToggle" class="md:hidden p-2 rounded hover:bg-gray-100 z-50 relative">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            {{-- Logo dan Judul --}}
            <div class="flex items-center space-x-2">
                <div class="bg-[#446FF2] p-2 rounded-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 4v16h16V4H4zm8 4v8m4-4H8" />
                    </svg>
                </div>
                <span class="text-[22px] font-semibold text-gray-800">Rekam Medis</span>
            </div>
        </div>

        {{-- Kanan: Info user (hanya md ke atas) --}}
        <div class="hidden md:flex items-center space-x-3">
            <div class="text-right">
                <div class="text-sm font-medium text-gray-800">
                    {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                </div>
                <div class="text-xs text-gray-500">
                    {{ Auth::user()?->role->nama_role ?? 'Tidak ada role' }}
                </div>
            </div>
            <div class="relative">
                <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zM12 14.4c-3 0-8.4 1.5-8.4 4.5V21h16.8v-2.1c0-3-5.4-4.5-8.4-4.5z" />
                    </svg>
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-white border rounded-full"></span>
                </div>
            </div>
        </div>
    </div>
</nav>
