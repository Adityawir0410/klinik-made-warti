<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Klinik Bidan Made Warthi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const icon = document.getElementById("toggleIcon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.setAttribute("d", "M1.293 8.293a1 1 0 011.414 0l1.06 1.06a8 8 0 0011.487 0l1.06-1.06a1 1 0 111.414 1.414l-1.06 1.06a10 10 0 01-14.122 0l-1.06-1.06a1 1 0 010-1.414z");
            } else {
                passwordInput.type = "password";
                icon.setAttribute("d", "M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z");
            }
        }
    </script>
</head>

<body class="bg-white min-h-screen flex flex-col">

    {{-- ✅ Navbar Login --}}
    @include('layouts.login-navbar')

    {{-- ✅ Konten login center --}}
    <main class="flex-1 flex items-center justify-center">
        <div class="flex w-full max-w-6xl min-h-[80vh] items-center justify-center flex-col md:flex-row gap-4 md:gap-8">

            <!-- Gambar kiri -->
            <div class="w-full md:w-[65%] flex items-center justify-center md:px-2 px-6">
                <img src="{{ asset('images/LoginBanner.svg') }}" alt="Login Banner"
                    class="w-full md:max-w-4xl h-auto object-contain" />
            </div>

            <!-- Form login kanan -->
            <div class="w-full md:w-[35%] md:px-2 px-6 flex items-center justify-center">
                <div class="bg-white w-full max-w-md">
                    <h2 class="text-[32px] font-bold text-gray-800 mb-4 text-center leading-tight">Rekam Medis</h2>
                    <p class="text-base text-gray-600 mb-8 text-center">Silakan masuk untuk mengakses sistem</p>

                    <form method="POST" action="{{ route('login.submit') }}" class="flex flex-col items-center space-y-5">
                        @csrf

                        {{-- Input Email --}}
                        <div class="relative w-full max-w-[411px]">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l9 6 9-6M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
                                </svg>
                            </span>
                            <input type="email" id="email" name="email" required placeholder="Email"
                                class="w-full pl-12 pr-4 h-[56px] bg-[#F7F7F7] border-none rounded-[14px] focus:outline-none focus:ring-2 focus:ring-blue-300 text-base" />
                        </div>

                        {{-- Input Password --}}
                        <div class="relative w-full max-w-[411px]">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 17a2 2 0 100-4 2 2 0 000 4zm6-6V9a6 6 0 10-12 0v2a2 2 0 00-2 2v7a2 2 0 002 2h12a2 2 0 002-2v-7a2 2 0 00-2-2zm-6-7a4 4 0 014 4v2H8V9a4 4 0 014-4z" />
                                </svg>
                            </span>
                            <input type="password" id="password" name="password" required placeholder="Password"
                                class="w-full pl-12 pr-12 h-[56px] bg-[#F7F7F7] border-none rounded-[14px] focus:outline-none focus:ring-2 focus:ring-blue-300 text-base" />
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer"
                                onclick="togglePassword()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path id="toggleIcon" stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </span>
                        </div>

                        {{-- Remember Me --}}
                        <div class="flex items-center w-full max-w-[411px] mt-2 mb-4">
                            <input id="remember" type="checkbox" name="remember"
                                class="mr-2 accent-[#446FF2] w-4 h-4 rounded focus:ring-2 focus:ring-blue-200 border-gray-300" />
                            <label for="remember" class="text-sm text-gray-700 select-none cursor-pointer">Ingat Saya</label>
                        </div>

                        {{-- Error Message --}}
                        @if ($errors->any())
                            <div class="text-sm text-red-600 text-center w-full max-w-[411px] mt-2">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        {{-- Submit Button --}}
                        <button type="submit"
                            class="w-full max-w-[411px] h-[56px] bg-[#446FF2] hover:bg-blue-700 text-white font-semibold rounded-[14px] transition text-base mt-4">
                            Masuk
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <div class="w-full text-center text-xs text-gray-400 mt-8 mb-4 select-none">
        © 2025 Rekam Medis Klinik Bidan Made Warthi
    </div>

</body>

</html>
