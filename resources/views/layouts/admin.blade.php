<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Handal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-slate-50 antialiased flex">

    <aside class="w-64 bg-slate-900 min-h-screen flex flex-col sticky top-0 shadow-xl z-50">
        <div class="p-6">
            <h1 class="text-xl font-bold text-white tracking-wider">ADMIN PANEL</h1>
            <p class="text-xs text-slate-500 mt-1">Handal Sekolah Aman</p>
        </div>

        <nav class="flex-grow px-4 space-y-2 overflow-y-auto">

            {{-- =============================================== --}}
            {{-- MENU VALIDATOR                                  --}}
            {{-- =============================================== --}}
            @if (Auth::user()->role === 'validator')
                <a href="{{ route('validator.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors
                   {{ request()->routeIs('validator.dashboard') || request()->routeIs('validator.show') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            @endif

            {{-- =============================================== --}}
            {{-- MENU ADMIN                                      --}}
            {{-- =============================================== --}}
            @if (Auth::user()->role === 'admin')
                {{-- GROUP 1: UTAMA --}}
                <div class="px-2 mt-4 mb-2 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    Utama
                </div>

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

                {{-- GROUP 2: MANAJEMEN SURVEI (BARU) --}}
                <div class="px-2 mt-6 mb-2 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    Manajemen Survei
                </div>

                {{-- Menu Kategori / Bab --}}
                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors
                   {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-tags-fill"></i> Kategori (Bab)
                </a>

                {{-- Menu Pertanyaan --}}
                <a href="{{ route('admin.questions.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors
                   {{ request()->routeIs('admin.questions.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-question-circle-fill"></i> Pertanyaan
                </a>
            @endif

        </nav>

        {{-- LOGOUT --}}
        <div class="p-4 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    class="w-full flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-red-900/30 rounded-lg transition-colors">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-grow p-8 h-screen overflow-y-auto">
        @yield('content')
    </main>

</body>

</html>
