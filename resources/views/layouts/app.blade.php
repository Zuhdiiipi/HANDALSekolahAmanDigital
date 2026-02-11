<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Handal - Sekolah Aman Digital')</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Alpine.js (WAJIB ADA untuk Mobile Menu) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#2563EB' }
                }
            }
        }
    </script>
</head>

<body class="font-sans antialiased bg-slate-50 flex flex-col min-h-full">

    {{-- NAVBAR RESPONSIF --}}
    {{-- x-data digunakan untuk mengontrol state buka/tutup menu mobile --}}
    <nav class="bg-blue-600 shadow-lg sticky top-0 z-50 transition-all duration-300" x-data="{ open: false }">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-center h-20">

                {{-- KIRI: LOGO --}}
                <a href="/" class="flex items-center gap-3 group">
                    <img src="{{ asset('img/Handal 8.png') }}" 
                         alt="Logo Handal" 
                         class="h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-md">
                </a>

                {{-- TENGAH/KANAN: MENU DESKTOP (Hidden di HP) --}}
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        @if (Auth::user()->role === 'school')
                            <div class="inline-flex items-center gap-1 bg-blue-800/40 backdrop-blur-md rounded-full p-1 border border-blue-400/30 shadow-inner">
                                <a href="{{ route('school.dashboard') }}" 
                                   class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-300 flex items-center gap-2
                                   {{ request()->routeIs('school.dashboard') ? 'bg-white text-blue-600 shadow-md' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                                    <i class="bi bi-grid-fill"></i> Dashboard
                                </a>
                                <a href="{{ route('school.profile.edit') }}" 
                                   class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-300 flex items-center gap-2
                                   {{ request()->routeIs('school.profile.edit') ? 'bg-white text-blue-600 shadow-md' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                                    <i class="bi bi-person-circle"></i> Profil
                                </a>
                            </div>
                        @endif

                        <div class="h-6 w-px bg-blue-400 mx-2"></div>

                        <div class="flex items-center gap-3">
                            <span class="text-sm font-medium text-blue-50">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-700 text-blue-200 hover:bg-red-500 hover:text-white border border-blue-500 hover:border-red-400 transition-all shadow-sm" title="Keluar">
                                    <i class="bi bi-box-arrow-right text-lg"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="group flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-blue-700 bg-white hover:bg-slate-100 rounded-full shadow-lg transition-all transform hover:-translate-y-0.5">
                            <i class="bi bi-person-circle text-lg opacity-80 group-hover:opacity-100"></i>
                            <span>Masuk</span>
                        </a>
                    @endauth
                </div>

                {{-- KANAN: TOMBOL HAMBURGER MOBILE (Visible HANYA di HP) --}}
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="text-white p-2 focus:outline-none hover:bg-blue-700 rounded-lg transition-colors">
                        <i class="bi text-3xl" :class="open ? 'bi-x-lg' : 'bi-list'"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- MOBILE MENU DROPDOWN (Muncul saat Hamburger diklik) --}}
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden bg-blue-700 border-t border-blue-500 shadow-inner" 
             style="display: none;">
            
            <div class="px-4 pt-4 pb-6 space-y-3">
                @auth
                    <div class="flex items-center gap-3 mb-4 px-2">
                        <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-lg">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-white font-bold">{{ Auth::user()->name }}</p>
                            <p class="text-blue-200 text-xs">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    @if (Auth::user()->role === 'school')
                        <a href="{{ route('school.dashboard') }}" class="block px-4 py-3 rounded-xl bg-blue-800 text-white font-bold hover:bg-blue-900 transition-colors border border-blue-600">
                            <i class="bi bi-grid-fill mr-2"></i> Dashboard
                        </a>
                        <a href="{{ route('school.profile.edit') }}" class="block px-4 py-3 rounded-xl bg-blue-800 text-white font-bold hover:bg-blue-900 transition-colors border border-blue-600">
                            <i class="bi bi-person-circle mr-2"></i> Profil Sekolah
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="pt-2">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 rounded-xl bg-red-500/20 text-red-100 font-bold hover:bg-red-500 hover:text-white transition-colors border border-red-500/30">
                            <i class="bi bi-box-arrow-right mr-2"></i> Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 rounded-xl bg-white text-blue-700 font-bold shadow-md hover:bg-slate-100">
                        Masuk Akun
                    </a>
                    <a href="{{ route('registration.page') }}" class="block w-full text-center px-4 py-3 rounded-xl border border-white/30 text-white font-bold hover:bg-white/10">
                        Daftar Sekolah Baru
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- FOOTER (Sudah Responsif Bawaan) --}}
    <footer class="bg-slate-900 text-slate-400 border-t border-slate-800 mt-auto relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 via-cyan-500 to-blue-600"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-6 pt-16 pb-8">
            {{-- Grid Responsif: 1 kolom di HP, 2 di Tablet, 4 di Desktop --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                
                {{-- KOLOM 1 --}}
                <div class="space-y-6 text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start">
                        <img src="{{ asset('img/Handal 8.png') }}" class="h-14 w-auto object-contain" alt="Logo HANDAL">
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Platform resmi pemeringkatan dan asesmen keamanan digital untuk mewujudkan ekosistem sekolah yang aman.
                    </p>
                </div>

                {{-- KOLOM 2 --}}
                <div class="text-center md:text-left">
                    <h3 class="text-white font-bold uppercase tracking-wider text-sm mb-6 border-l-0 md:border-l-4 border-blue-600 md:pl-3">Jelajahi</h3>
                    <ul class="space-y-4 text-sm">
                        <li><a href="/" class="hover:text-blue-400 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('ranking.page') }}" class="hover:text-blue-400 transition-colors">Peringkat Sekolah</a></li>
                        <li><a href="{{ route('registration.page') }}" class="hover:text-blue-400 transition-colors">Daftar Sekolah</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Panduan Teknis</a></li>
                    </ul>
                </div>

                {{-- KOLOM 3 --}}
                <div class="text-center md:text-left">
                    <h3 class="text-white font-bold uppercase tracking-wider text-sm mb-6 border-l-0 md:border-l-4 border-blue-600 md:pl-3">Hubungi Kami</h3>
                    <ul class="space-y-4 text-sm flex flex-col items-center md:items-start">
                        <li class="flex items-start gap-3">
                            <i class="bi bi-geo-alt-fill text-blue-500 mt-0.5"></i>
                            <span>BBPSDM Komdigi Makassar<br>Jl. Prof. Abdurahman Basalamah</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="bi bi-envelope-fill text-blue-500"></i>
                            <a href="mailto:info@handalsekolah.id" class="hover:text-white">info@handalsekolah.id</a>
                        </li>
                    </ul>
                </div>

                {{-- KOLOM 4 --}}
                <div class="text-center md:text-left">
                    <h3 class="text-white font-bold uppercase tracking-wider text-sm mb-6 border-l-0 md:border-l-4 border-blue-600 md:pl-3">Ikuti Kami</h3>
                    <div class="flex gap-4 justify-center md:justify-start">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-pink-600 hover:text-white transition-all"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-sky-500 hover:text-white transition-all"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-red-600 hover:text-white transition-all"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 mt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-center md:text-left">
                <p>&copy; {{ date('Y') }} <span class="text-blue-400 font-bold">Handal Sekolah Aman Digital</span>. Hak Cipta Dilindungi.</p>
                <div class="flex gap-4 md:gap-6 justify-center">
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Bantuan</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>