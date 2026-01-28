<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validator Dashboard - Handal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-slate-50 antialiased flex">

    <aside class="w-64 bg-slate-900 min-h-screen flex flex-col sticky top-0">
        <div class="p-6">
            <h1 class="text-xl font-bold text-white tracking-wider">VALIDATOR PANEL</h1>
        </div>
        <nav class="flex-grow px-4 space-y-2">

            @if (Auth::user()->role === 'validator')
                <a href="{{ route('validator.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors
           {{ request()->routeIs('validator.dashboard') || request()->routeIs('validator.show') ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            @endif

            @if (Auth::user()->role === 'admin')
                {{-- 1. Dashboard Admin --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors
           {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                <a href="{{ route('admin.registrations.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors
           {{ request()->routeIs('admin.registrations.*') ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="bi bi-person-check-fill"></i> Penerbitan Akun
                </a>
            @endif

        </nav>
        <div class="p-4 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    class="w-full flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white transition-colors">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-grow p-8">
        @yield('content')
    </main>

</body>

</html>
