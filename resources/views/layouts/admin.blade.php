<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Handal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

{{-- Ubah 'flex' menjadi 'flex-col md:flex-row' agar layout bisa menumpuk di HP dan menyamping di PC --}}

<body class="bg-slate-50 antialiased flex flex-col md:flex-row min-h-screen relative">

    {{-- 1. HEADER MOBILE (Hanya muncul di layar kecil / md:hidden) --}}
    <header class="bg-slate-900 text-white p-4 flex justify-between items-center md:hidden sticky top-0 z-40 shadow-md">
        <span class="font-bold tracking-wider">ADMIN PANEL</span>
        <button onclick="toggleSidebar()" class="text-white hover:text-slate-300 focus:outline-none">
            <i class="bi bi-list text-3xl"></i> {{-- Icon Garis 3 --}}
        </button>
    </header>

    {{-- 2. OVERLAY GELAP (Background saat menu terbuka di HP) --}}
    <div id="sidebarOverlay" onclick="closeSidebar()"
        class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity opacity-0 md:hidden">
    </div>

    {{-- 3. SIDEBAR (Dimodifikasi agar responsif) --}}
    {{-- 
         - fixed inset-y-0 left-0: Menempel di kiri layar penuh
         - transform -translate-x-full: Defaultnya sembunyi ke kiri (keluar layar)
         - md:translate-x-0: Di layar Desktop, sidebar kembali muncul normal
         - md:static: Di desktop posisinya tidak melayang (fixed), tapi statis/sticky sesuai layout
         - transition-transform: Efek animasi geser halus
    --}}
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white transform -translate-x-full transition-transform duration-300 ease-in-out 
                  md:translate-x-0 md:static md:sticky md:top-0 md:h-screen md:flex md:flex-col shadow-xl">

        {{-- Header Sidebar (Logo + Tombol Close di HP) --}}
        <div class="p-6 flex justify-between items-start">
            <div>
                <h1 class="text-xl font-bold text-white tracking-wider">ADMIN PANEL</h1>
                <p class="text-xs text-slate-500 mt-1">Handal Sekolah Aman</p>
            </div>
            {{-- Tombol Close (X) hanya muncul di HP --}}
            <button onclick="closeSidebar()" class="md:hidden text-slate-400 hover:text-white">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>

        {{-- Navigasi --}}
        <nav class="flex-grow px-4 space-y-2 overflow-y-auto pb-20 md:pb-0">

            {{-- MENU VALIDATOR --}}
            @if (Auth::user()->role === 'validator')
                <a href="{{ route('validator.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors
                   {{ request()->routeIs('validator.dashboard') || request()->routeIs('validator.show') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            @endif

            {{-- MENU ADMIN --}}
            @if (Auth::user()->role === 'admin')
                <div class="px-2 mt-4 mb-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Utama</div>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors
                   {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>

                <a href="{{ route('admin.registrations.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors
                   {{ request()->routeIs('admin.registrations.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-person-check-fill"></i> Penerbitan Akun
                </a>

                <div class="px-2 mt-6 mb-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Manajemen Survei
                </div>

                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors
                   {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-tags-fill"></i> Kategori (Bab)
                </a>

                <a href="{{ route('admin.questions.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors
                   {{ request()->routeIs('admin.questions.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-question-circle-fill"></i> Pertanyaan
                </a>
            @endif
        </nav>

        {{-- LOGOUT --}}
        <div class="p-4 border-t border-slate-800 bg-slate-900 md:bg-transparent absolute bottom-0 w-full md:relative">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    class="w-full flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-red-900/30 rounded-lg transition-colors">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- 4. KONTEN UTAMA --}}
    <main class="flex-grow p-4 md:p-8 w-full md:w-auto overflow-x-hidden">
        @yield('content')
    </main>

    {{-- 5. SCRIPT JAVASCRIPT UNTUK TOGGLE MENU --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            // Hapus class translate (agar sidebar masuk ke layar)
            sidebar.classList.toggle('-translate-x-full');

            // Tampilkan Overlay
            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10); // Efek fade-in
            } else {
                closeSidebar();
            }
        }

        function closeSidebar() {
            // Sembunyikan sidebar ke kiri lagi
            sidebar.classList.add('-translate-x-full');

            // Sembunyikan Overlay
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300); // Tunggu animasi selesai
        }
    </script>

</body>

</html>
