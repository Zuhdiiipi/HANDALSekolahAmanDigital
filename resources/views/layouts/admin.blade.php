<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Handal')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-slate-50 antialiased flex flex-col md:flex-row min-h-screen relative text-slate-800">

    <header
        class="bg-slate-900 text-white p-4 flex justify-between items-center md:hidden sticky top-0 z-40 shadow-lg border-b border-slate-800">
        <div class="flex items-center gap-3">
            <img src="{{ asset('img/Handal 8.png') }}" class="h-8 w-auto brightness-0 invert" alt="Logo">
            <span class="font-bold tracking-wider text-sm">ADMIN PANEL</span>
        </div>
        <button onclick="toggleSidebar()"
            class="text-white hover:text-blue-400 transition-colors focus:outline-none p-1">
            <i class="bi bi-list text-3xl"></i>
        </button>
    </header>

    <div id="sidebarOverlay" onclick="closeSidebar()"
        class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-40 hidden transition-opacity opacity-0 md:hidden">
    </div>

    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-slate-300 transform -translate-x-full transition-transform duration-300 ease-in-out 
               md:translate-x-0 md:static md:sticky md:top-0 md:h-screen md:flex md:flex-col shadow-2xl border-r border-slate-800">

        <div
            class="py-8 px-6 border-b border-slate-800 bg-slate-900 relative flex flex-col items-center justify-center text-center">
            <button onclick="closeSidebar()"
                class="md:hidden absolute top-4 right-4 text-slate-500 hover:text-white transition-colors">
                <i class="bi bi-x-lg text-lg"></i>
            </button>

            <div class="mb-4">
                <img src="{{ asset('img/Handal 8.png') }}"
                    class="h-14 w-auto drop-shadow-md hover:scale-105 transition-transform" alt="Logo Handal">
            </div>

            <div>
                <h1 class="text-xl font-black text-white tracking-tight leading-none mb-2">HANDAL</h1>
                <span
                    class="inline-block px-3 py-1 rounded-full text-[10px] font-bold bg-slate-800 text-blue-400 uppercase tracking-widest border border-slate-700 shadow-sm">
                    Admin Panel
                </span>
            </div>
        </div>

        <nav class="flex-grow px-4 py-6 space-y-1 overflow-y-auto no-scrollbar">

            @if (Auth::user()->role === 'validator')
                <div class="px-3 mb-3 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Area Kerja</div>

                <a href="{{ route('validator.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 group
                   {{ request()->routeIs('validator.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i
                        class="bi bi-speedometer2 text-lg {{ request()->routeIs('validator.dashboard') ? 'text-white' : 'group-hover:text-blue-400' }}"></i>
                    <span>Dashboard</span>
                </a>
            @endif

            @if (Auth::user()->role === 'admin')
                <div class="px-3 mt-2 mb-3 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Utama</div>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 group mb-1
                   {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i
                        class="bi bi-grid-1x2-fill text-lg {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'group-hover:text-blue-400' }}"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.registrations.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 group
                   {{ request()->routeIs('admin.registrations.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i
                        class="bi bi-person-check-fill text-lg {{ request()->routeIs('admin.registrations.*') ? 'text-white' : 'group-hover:text-blue-400' }}"></i>
                    <span>Penerbitan Akun</span>
                </a>

                <div class="px-3 mt-8 mb-3 text-[11px] font-bold text-slate-500 uppercase tracking-widest">Manajemen
                    Data</div>

                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 group mb-1
                   {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i
                        class="bi bi-tags-fill text-lg {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'group-hover:text-purple-400' }}"></i>
                    <span>Kategori (Bab)</span>
                </a>

                <a href="{{ route('admin.questions.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 group
                   {{ request()->routeIs('admin.questions.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i
                        class="bi bi-question-circle-fill text-lg {{ request()->routeIs('admin.questions.*') ? 'text-white' : 'group-hover:text-purple-400' }}"></i>
                    <span>Bank Pertanyaan</span>
                </a>
            @endif

        </nav>

        <div class="p-4 border-t border-slate-800 bg-slate-900/50">

            <div class="flex items-center gap-3 mb-4 px-2">
                <div
                    class="w-9 h-9 rounded-full bg-gradient-to-tr from-blue-500 to-cyan-400 flex items-center justify-center text-white font-bold text-sm shadow-md">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold text-white truncate w-32">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-500 truncate capitalize">{{ Auth::user()->role }}</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-bold text-red-400 bg-red-500/10 hover:bg-red-500 hover:text-white rounded-lg transition-all duration-200 group">
                    <i class="bi bi-box-arrow-right text-sm group-hover:text-white"></i>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>

    </aside>

    <main class="flex-grow p-4 md:p-8 w-full md:w-auto overflow-x-hidden min-h-screen">
        {{-- Area ini akan diisi oleh file dashboard.blade.php Anda --}}
        @yield('content')
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');

            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
            } else {
                closeSidebar();
            }
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300);
        }
    </script>

</body>

</html>
