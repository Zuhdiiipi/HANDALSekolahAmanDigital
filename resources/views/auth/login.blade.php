@extends('layouts.app')

@section('title', 'Login - Handal Sekolah')

@section('content')
<div class="min-h-screen flex relative overflow-hidden bg-slate-50">
    
    {{-- BAGIAN KIRI: BRANDING & VISUAL (DESKTOP) --}}
    <div class="hidden lg:flex lg:w-1/2 relative z-10 overflow-hidden group bg-blue-900">
        {{-- Gambar Background --}}
        <img src="{{ asset('img/SAMPUL FINAL XTRA COLOR 2.jpg') }}" 
             class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay transition-transform duration-[20s] group-hover:scale-110"
             alt="Background Sekolah">
        
        {{-- Overlay Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 opacity-90"></div>

        {{-- Pattern Grid --}}
        <div class="absolute inset-0 opacity-10" 
             style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 30px 30px;">
        </div>

        {{-- Dekorasi Cahaya --}}
        <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-b from-transparent to-blue-950/50"></div>

        {{-- Konten Text --}}
        <div class="relative z-20 w-full flex flex-col justify-between p-16 text-white h-full">
            
            <div class="flex items-center gap-3 opacity-90">
                <div class="w-1 h-8 bg-blue-400 rounded-full"></div>
                <span class="text-sm font-bold tracking-widest uppercase">Handal Security</span>
            </div>

            <div>
                <h2 class="text-5xl font-black mb-6 leading-tight drop-shadow-md">
                    Keamanan Digital <br> 
                    <span class="text-blue-300">Dimulai dari Sini.</span>
                </h2>
                <div class="h-1.5 w-24 bg-blue-500 rounded-full mb-6"></div>
                <p class="text-blue-100 text-lg leading-relaxed max-w-md font-light">
                    Sistem terintegrasi untuk menciptakan ekosistem pendidikan yang aman, nyaman, dan terverifikasi standar nasional.
                </p>
            </div>

            <div class="flex justify-between items-end border-t border-blue-500/30 pt-8">
                <div class="text-xs text-blue-200">
                    &copy; 2026 BBLSDM Komdigi Makassar
                </div>
                <div class="flex gap-2">
                    <span class="w-8 h-1.5 rounded-full bg-blue-400"></span>
                    <span class="w-2 h-1.5 rounded-full bg-blue-400/30"></span>
                    <span class="w-2 h-1.5 rounded-full bg-blue-400/30"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN KANAN: FORM LOGIN --}}
    <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-20 xl:px-24 relative z-10 bg-white">
        
        <div class="lg:hidden absolute top-0 left-0 w-full h-2 bg-blue-600"></div>

        <div class="mx-auto w-full max-w-sm lg:w-[26rem]">
            
            <div class="mb-8 text-center lg:text-left">
                <img class="h-14 w-auto mb-6 mx-auto lg:mx-0 lg:hidden drop-shadow-sm" src="{{ asset('img/Handal 8.png') }}" alt="Handal Logo">
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">Selamat Datang</h2>
                <p class="mt-2 text-sm text-slate-500 font-medium">
                    Masuk ke panel admin sekolah.
                </p>
            </div>

            {{-- >>>>> ALERT ERROR (BARU) <<<<< --}}
            {{-- Ini akan muncul jika ada error dari Controller (misal: Auth::attempt gagal) --}}
            @if ($errors->any() || session('error'))
                <div class="mb-6 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl flex items-start gap-3 shadow-sm" role="alert">
                    <div class="mt-0.5">
                        <i class="bi bi-exclamation-triangle-fill text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Login Gagal</h3>
                        <p class="text-xs mt-1 leading-relaxed">
                            {{ session('error') ?? 'Email atau password yang Anda masukkan tidak sesuai.' }}
                        </p>
                    </div>
                </div>
            @endif
            {{-- >>>>> END ALERT <<<<< --}}

            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Input Email --}}
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Email Sekolah</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-envelope-fill text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="block w-full pl-11 pr-4 py-3.5 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 transition-all duration-200 sm:text-sm font-medium @error('email') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" 
                            placeholder="admin@sekolah.sch.id">
                    </div>
                    {{-- Pesan error spesifik field email --}}
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 ml-1 font-medium flex items-center gap-1">
                            <i class="bi bi-x-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Input Password --}}
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-shield-lock-fill text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                        </div>
                        
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                            class="block w-full pl-11 pr-12 py-3.5 border border-slate-200 rounded-xl bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 transition-all duration-200 sm:text-sm font-medium @error('password') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror" 
                            placeholder="••••••••">

                        {{-- Tombol Mata --}}
                        <button type="button" onclick="animateBlink()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-600 focus:outline-none transition-colors cursor-pointer z-10">
                            <i id="eyeIcon" class="bi bi-eye-slash text-lg inline-block origin-center transition-all duration-200 ease-in-out"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember & Forgot --}}
                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                        <label for="remember-me" class="ml-2 block text-sm text-slate-600 cursor-pointer select-none font-medium">Ingat saya</label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-bold text-blue-600 hover:text-blue-800 transition-colors">Lupa password?</a>
                    </div>
                </div>

                {{-- Button --}}
                <div class="pt-2">
                    <button type="submit" class="group w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-900/20 text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition-all duration-200 hover:-translate-y-1">
                        <span class="flex items-center gap-2">
                            Masuk Dashboard <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </button>
                </div>
            </form>

            {{-- Register Link --}}
            <div class="mt-8 text-center">
                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs uppercase tracking-wide font-bold">
                        <span class="px-4 bg-white text-slate-400">Atau</span>
                    </div>
                </div>
                
                <a href="{{ route('registration.page') }}" class="w-full flex items-center justify-center gap-2 py-3.5 px-4 border-2 border-slate-100 rounded-xl text-sm font-bold text-slate-600 bg-white hover:bg-slate-50 hover:border-slate-300 hover:text-blue-700 transition-all duration-200 group">
                    <i class="bi bi-building-add text-lg text-slate-400 group-hover:text-blue-600 transition-colors"></i>
                    Daftarkan Sekolah Baru
                </a>
            </div>

        </div>
    </div>
</div>

{{-- SCRIPT: ANIMASI KEDIP MATA --}}
<script>
    function animateBlink() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        // 1. TAHAP MENUTUP MATA
        eyeIcon.style.transform = "scaleY(0.1)";
        eyeIcon.style.opacity = "0";

        setTimeout(() => {
            // 2. TAHAP TUKAR ICON
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
                eyeIcon.classList.add('text-blue-600'); 
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
                eyeIcon.classList.remove('text-blue-600'); 
            }

            // 3. TAHAP MEMBUKA MATA
            eyeIcon.style.transform = "scaleY(1)";
            eyeIcon.style.opacity = "1";

        }, 200); 
    }
</script>

@endsection