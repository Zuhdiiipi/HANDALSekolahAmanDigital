@extends('layouts.app')

@section('content')
    <div class="relative w-full overflow-hidden">

        <div class="absolute inset-0 bg-gradient-to-b from-blue-50 via-white to-slate-50 -z-30"></div>

        <div class="absolute inset-0 -z-20 opacity-30 pointer-events-none"
            style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 32px 32px;">
        </div>

        <div
            class="absolute -top-20 -right-20 w-[500px] h-[500px] bg-blue-300/30 rounded-full blur-[100px] -z-20 mix-blend-multiply animate-pulse">
        </div>

        <div
            class="absolute bottom-0 -left-20 w-[500px] h-[500px] bg-cyan-300/30 rounded-full blur-[100px] -z-20 mix-blend-multiply">
        </div>

        <div class="absolute -top-10 -left-10 w-[600px] opacity-20 -z-20 pointer-events-none mix-blend-multiply">
            <img src="{{ asset('img/1.png') }}" class="w-full" alt="Pattern">
        </div>
        <div class="hidden lg:block absolute top-20 left-24 -z-10 animate-[bounce_4s_infinite]">
            <div
                class="w-16 h-16 bg-white/50 backdrop-blur-md rounded-2xl border border-white/50 shadow-sm flex items-center justify-center transform -rotate-12">
                <i class="bi bi-shield-lock text-3xl text-blue-500"></i>
            </div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-28">

            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center mb-28">
                <div class="order-2 lg:order-1">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 mb-6 rounded-full bg-blue-100 text-blue-700 text-sm font-bold border border-blue-200">
                        <i class="bi bi-shield-check"></i> BBPSDM Komdigi Makassar
                    </span>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                        Wujudkan Ekosistem <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">
                            Sekolah Aman Digital
                        </span>
                    </h1>

                    <p class="text-lg text-slate-600 leading-relaxed max-w-xl mb-8">
                        Platform resmi pemeringkatan (HANDAL) untuk mengukur kesiapan dan keamanan digital sekolah menengah
                        di Indonesia.
                    </p>

                    <div
                        class="inline-flex items-center gap-6 bg-white/80 backdrop-blur px-5 py-3 rounded-2xl border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-2 text-sm font-medium text-slate-700">
                            <span class="relative flex h-3 w-3">
                                <span
                                    class="absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75 animate-ping"></span>
                                <span class="relative inline-flex h-3 w-3 rounded-full bg-green-500"></span>
                            </span>
                            Terverifikasi
                        </div>
                        <div class="h-4 w-px bg-slate-300"></div>
                        <div class="flex items-center gap-2 text-sm font-medium text-slate-700">
                            <i class="bi bi-database text-blue-600"></i> Data Real-time
                        </div>
                    </div>
                </div>

                <div class="relative order-1 lg:order-2 group">
                    <div
                        class="absolute -inset-4 bg-gradient-to-tr from-blue-400 to-cyan-300 rounded-[2.5rem] blur-2xl opacity-30 group-hover:opacity-50 transition duration-500">
                    </div>
                    <div
                        class="relative rounded-[2rem] overflow-hidden shadow-2xl border-[6px] border-white transform transition duration-500 hover:scale-[1.02]">
                        <img src="{{ asset('img/SAMPUL FINAL XTRA COLOR 2.jpg') }}" class="w-full h-auto object-cover">
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto mb-28">
                <div
                    class="group relative bg-white p-8 md:p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                    <div
                        class="absolute -right-12 -bottom-12 opacity-5 pointer-events-none group-hover:opacity-10 transition-opacity">
                        <i class="bi bi-pencil-square text-[10rem] text-blue-600 -rotate-12"></i>
                    </div>

                    <div
                        class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 text-3xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <i class="bi bi-pencil-square"></i>
                    </div>

                    <h3 class="text-2xl font-bold text-slate-900 mb-3">Isi Asesmen Sekolah</h3>
                    <p class="text-slate-500 mb-8">Lakukan evaluasi mandiri kesiapan digital sekolah Anda.</p>

                    @auth
                        @if (Auth::user()->role === 'school')
                            <a href="{{ route('school.survey.start') }}"
                                class="inline-flex items-center font-bold text-blue-600 hover:gap-3 transition-all">Mulai
                                Sekarang <i class="bi bi-arrow-right ml-2"></i></a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center font-bold text-blue-600 hover:gap-3 transition-all">Ke Dashboard
                                <i class="bi bi-arrow-right ml-2"></i></a>
                        @endif
                    @else
                        <a href="{{ route('registration.page') }}"
                            class="inline-flex items-center font-bold text-blue-600 hover:gap-3 transition-all">Masuk untuk
                            Mulai <i class="bi bi-arrow-right ml-2"></i></a>
                    @endauth
                </div>

                <div
                    class="group relative bg-white p-8 md:p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                    <div
                        class="absolute -right-12 -bottom-12 opacity-5 pointer-events-none group-hover:opacity-10 transition-opacity">
                        <i class="bi bi-trophy-fill text-[10rem] text-emerald-600 rotate-12"></i>
                    </div>

                    <div
                        class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-3xl mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                        <i class="bi bi-trophy-fill"></i>
                    </div>

                    <h3 class="text-2xl font-bold text-slate-900 mb-3">Peringkat Sekolah</h3>
                    <p class="text-slate-500 mb-8">Lihat sekolah dengan indeks keamanan terbaik.</p>

                    <a href="{{ route('ranking.page') }}"
                        class="inline-flex items-center font-bold text-emerald-600 hover:gap-3 transition-all">Lihat
                        Leaderboard <i class="bi bi-arrow-right ml-2"></i></a>
                </div>
            </div>

            <div class="mt-20 mb-20">

                <div class="mt-20 mb-20">
                    <div class="text-center mb-16 px-4">
                        <span
                            class="inline-block py-1 px-3 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-xs font-bold tracking-wider uppercase mb-4">
                            Dokumentasi Kegiatan
                        </span>
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 mb-6">
                            Jejak Langkah <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">HANDAL</span>
                        </h2>
                        <p class="text-slate-500 max-w-2xl mx-auto text-lg leading-relaxed">
                            Melihat lebih dekat bagaimana kami berkolaborasi dengan sekolah-sekolah di Indonesia untuk
                            menciptakan ruang digital yang aman.
                        </p>
                    </div>
                    <div x-data="{
                        activeSlide: 0,
                        slides: [
                            { img: '{{ asset('img/SAMPUL FINAL XTRA COLOR 2.jpg') }}', title: 'SMK Negeri 1 Makassar', desc: 'Sosialisasi Literasi Digital', date: '12 Jan 2026' },
                            { img: '{{ asset('img/SAMPUL FINAL XTRA COLOR 2.jpg') }}', title: 'SMA Islam Athirah', desc: 'Workshop Keamanan Siber', date: '05 Feb 2026' },
                            { img: '{{ asset('img/SAMPUL FINAL XTRA COLOR 2.jpg') }}', title: 'MAN 2 Model Makassar', desc: 'Monitoring Jaringan', date: '28 Jan 2026' }
                        ],
                        next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
                        prev() { this.activeSlide = (this.activeSlide === 0) ? this.slides.length - 1 : this.activeSlide - 1 },
                        timer: null,
                        init() { this.timer = setInterval(() => this.next(), 5000) },
                        stop() { clearInterval(this.timer) },
                        start() { this.timer = setInterval(() => this.next(), 5000) }
                    }" @mouseenter="stop()" @mouseleave="start()"
                        class="relative max-w-6xl mx-auto rounded-[2rem] overflow-hidden shadow-2xl bg-slate-900 group h-[500px]">

                        <template x-for="(slide, index) in slides" :key="index">
                            <div x-show="activeSlide === index"
                                x-transition:enter="transition transform duration-700 ease-out"
                                x-transition:enter-start="opacity-0 scale-105"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition transform duration-500 ease-in"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0"
                                class="absolute inset-0">

                                <img :src="slide.img" class="w-full h-full object-cover opacity-80">

                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent">
                                </div>

                                <div class="absolute bottom-0 left-0 p-10 pb-20 md:p-14 md:pb-24 max-w-3xl">
                                    <span x-text="slide.date"
                                        class="inline-block px-3 py-1 mb-3 text-xs font-bold tracking-wider text-blue-300 uppercase bg-blue-900/50 backdrop-blur rounded-full border border-blue-500/30"></span>
                                    <h3 x-text="slide.title"
                                        class="text-3xl md:text-5xl font-bold text-white mb-3 leading-tight drop-shadow-lg">
                                    </h3>
                                    <p x-text="slide.desc"
                                        class="text-slate-300 text-lg md:text-xl font-light drop-shadow-md"></p>
                                </div>
                            </div>
                        </template>

                        <div class="absolute inset-0 flex items-center justify-between px-4 z-20 pointer-events-none">

                            <button @click="prev()"
                                class="pointer-events-auto opacity-0 group-hover:opacity-100 w-14 h-14 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-white hover:bg-white hover:text-blue-900 hover:scale-110 transition-all duration-300 flex items-center justify-center shadow-lg -ml-2 md:ml-0">
                                <i class="bi bi-chevron-left text-2xl"></i>
                            </button>

                            <button @click="next()"
                                class="pointer-events-auto opacity-0 group-hover:opacity-100 w-14 h-14 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-white hover:bg-white hover:text-blue-900 hover:scale-110 transition-all duration-300 flex items-center justify-center shadow-lg -mr-2 md:mr-0">
                                <i class="bi bi-chevron-right text-2xl"></i>
                            </button>

                        </div>

                        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex gap-2 z-20">
                            <template x-for="(slide, index) in slides" :key="index">
                                <button @click="activeSlide = index"
                                    class="h-1.5 rounded-full transition-all duration-500 ease-out shadow-sm cursor-pointer hover:bg-white"
                                    :class="activeSlide === index ? 'w-8 bg-blue-500' : 'w-2 bg-white/50'">
                                </button>
                            </template>
                        </div>

                    </div>
                </div>

                <div
                    class="relative max-w-6xl mx-auto px-6 py-20 rounded-[3rem] overflow-hidden shadow-2xl mb-24 text-center text-white group">

                    <div class="absolute inset-0 bg-gradient-to-br from-blue-700 via-blue-600 to-cyan-500 z-0"></div>

                    <div class="absolute -top-10 -right-10 opacity-10 animate-[bounce_6s_infinite]">
                        <i class="bi bi-shield-lock-fill text-[10rem]"></i>
                    </div>
                    <div class="absolute -bottom-10 -left-10 opacity-10 animate-[bounce_8s_infinite]">
                        <i class="bi bi-globe-asia-australia text-[10rem]"></i>
                    </div>

                    <div class="relative z-10">
                        <div
                            class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-sm font-semibold shadow-sm">
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                            Program Skala Nasional
                        </div>

                        <h2 class="text-4xl md:text-5xl font-extrabold mb-6 tracking-tight leading-tight">
                            Siap Menjadi Sekolah <br> <span class="text-blue-100">Aman Digital?</span>
                        </h2>

                        <p class="text-lg md:text-xl text-blue-50 max-w-2xl mx-auto mb-10 leading-relaxed font-light">
                            Bergabunglah dengan jaringan sekolah di seluruh Indonesia. Ikuti asesmen resmi dan dapatkan
                            sertifikasi keamanan digital.
                        </p>

                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            @auth
                                @if (Auth::user()->role === 'school')
                                    <a href="{{ route('school.survey.start') }}"
                                        class="group relative px-8 py-4 bg-white text-blue-700 font-bold rounded-2xl hover:scale-105 transition-all shadow-[0_10px_20px_-10px_rgba(255,255,255,0.5)] flex items-center justify-center gap-3">
                                        Mulai Asesmen
                                        <i
                                            class="bi bi-play-circle-fill text-xl group-hover:text-blue-500 transition-colors"></i>
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}"
                                        class="group relative px-8 py-4 bg-white text-blue-700 font-bold rounded-2xl hover:scale-105 transition-all shadow-[0_10px_20px_-10px_rgba(255,255,255,0.5)] flex items-center justify-center gap-3">
                                        Ke Dashboard
                                        <i class="bi bi-grid-fill text-xl group-hover:text-blue-500 transition-colors"></i>
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('registration.page') }}"
                                    class="group relative px-8 py-4 bg-white text-blue-700 font-bold rounded-2xl hover:scale-105 transition-all shadow-[0_10px_20px_-10px_rgba(255,255,255,0.5)] flex items-center justify-center gap-3">
                                    Daftar Sekolah Sekarang
                                    <i
                                        class="bi bi-arrow-right-circle-fill text-xl group-hover:text-blue-500 transition-colors"></i>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endsection
