<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') Handal</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
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
        /* Smooth scrolling untuk navigasi anchor */
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 flex flex-col min-h-full">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="text-2xl font-bold text-blue-600 tracking-tight hover:text-blue-700 transition-colors">
                    HANDAL
                </a>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center px-4 py-2 border border-blue-600 text-sm font-semibold rounded-lg text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">
                            Login
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