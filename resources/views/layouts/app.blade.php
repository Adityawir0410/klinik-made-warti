<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
</head>
<body class="bg-[#FAFAFA] min-h-screen">

    @auth
        {{-- Navbar + Sidebar untuk user login --}}
        @include('layouts.dashboard-navbar')

        <div class="flex pt-[80px]">
            {{-- Sidebar --}}
            @include('layouts.sidebar')

            {{-- Konten utama --}}
           <main class="w-full md:ml-64 px-6 py-4 transition-all duration-300">

                @yield('content')
            </main>
        </div>
    @else
        {{-- Jika belum login, tampilkan navbar login + isi --}}
        @include('layouts.login-navbar')

        <main class="pt-[80px] px-6 py-4">
            @yield('content')
        </main>
    @endauth

    {{-- Script sidebar toggle --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggle = document.getElementById("sidebarToggle");
            const sidebar = document.getElementById("sidebar");

            if (toggle && sidebar) {
                toggle.addEventListener("click", () => {
                    sidebar.classList.toggle("-translate-x-full");
                });
            }
        });
    </script>
</body>
</html>
