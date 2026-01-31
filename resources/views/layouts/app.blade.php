<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') Handal</title>

    <script src="https://cdn.tailwindcss.com"></script>

    {{-- TAMBAHAN: Bootstrap Icons (Penting untuk halaman Profil) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-50 flex flex-col min-h-full">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-center h-16">

                {{-- LOGO --}}
                <a href="/"
                    class="text-2xl font-bold text-blue-600 tracking-tight hover:text-blue-700 transition-colors">
                    HANDAL
                </a>

                {{-- MENU KANAN --}}
                <div class="flex items-center gap-2 md:gap-4">
                    @auth
                        {{-- GROUP MENU SEKOLAH --}}
                        @if (Auth::user()->role === 'school')
                            {{-- 1. Menu Dashboard --}}
                            <a href="{{ route('school.dashboard') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg transition-all duration-200
                                {{ request()->routeIs('school.dashboard')
                                    ? 'bg-blue-50 text-blue-700 border border-blue-200'
                                    : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
                                <i class="bi bi-speedometer2"></i>
                                <span class="hidden md:inline">Dashboard</span>
                            </a>

                            {{-- 2. Menu Profil Sekolah (BARU) --}}
                            <a href="{{ route('school.profile.edit') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg transition-all duration-200
                                {{ request()->routeIs('school.profile.*')
                                    ? 'bg-blue-50 text-blue-700 border border-blue-200'
                                    : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
                                <i class="bi bi-building-gear"></i>
                                <span class="hidden md:inline">Profil Sekolah</span>
                            </a>

                            {{-- Divider Kecil --}}
                            <div class="h-6 w-px bg-slate-200 mx-1"></div>
                        @endif

                        {{-- TOMBOL LOGOUT --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                <i class="bi bi-box-arrow-right text-lg"></i>
                                <span class="hidden md:inline">Logout</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                            <i class="bi bi-box-arrow-in-right text-lg"></i>
                            <span>Login</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 md:px-6 py-10">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="container mx-auto px-4 md:px-6 py-8">
            <p class="text-center text-slate-500 text-sm">
                &copy; 2026 <span class="font-semibold">Handal Sekolah Aman Digital</span> — BBPSDM Komdigi Makassar
            </p>
        </div>
    </footer>

</body>

</html>
