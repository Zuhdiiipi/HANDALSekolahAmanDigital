@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- 1. HEADER --}}
        {{-- 1. HEADER --}}
        <div class="text-center mb-12 relative">
            
            {{-- Efek Glow/Cahaya Kuning di belakang trophy --}}
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-yellow-300/40 blur-3xl rounded-full -z-10"></div>

            {{-- Container Trophy --}}
            <div class="group relative inline-flex items-center justify-center w-28 h-28 bg-gradient-to-b from-white to-yellow-50 rounded-full mb-6 shadow-[0_15px_40px_-10px_rgba(250,204,21,0.5)] border-4 border-white ring-1 ring-yellow-200 transform transition-all duration-500 hover:scale-110 hover:-translate-y-2 overflow-hidden">
                
                {{-- Animasi Kilatan Cahaya (Shine Sweep) saat Hover --}}
                <div class="absolute top-0 -left-[100%] w-full h-full bg-gradient-to-r from-transparent via-white/80 to-transparent skew-x-[25deg] transition-all duration-1000 group-hover:left-[200%] z-20"></div>

                {{-- Ikon Trophy dengan Gradasi Kuning Cerah --}}
                <i class="bi bi-trophy-fill text-6xl text-transparent bg-clip-text bg-gradient-to-br from-yellow-300 via-yellow-400 to-yellow-500 drop-shadow-sm filter z-10 relative"></i>
                
                {{-- Dekorasi Partikel Bintang --}}
                <div class="absolute top-6 right-7 text-yellow-400 animate-pulse z-10">
                    <i class="bi bi-star-fill text-[8px]"></i>
                </div>
            </div>

            {{-- Judul & Tahun --}}
            <h1 class="text-4xl font-black text-slate-800 tracking-tight mb-2">Laporan Hasil Asesmen</h1>
            
            <p class="text-slate-500 font-medium text-lg">
                Periode Evaluasi Tahun 
                <span class="inline-block font-bold text-yellow-700 bg-yellow-50 px-3 py-0.5 rounded-lg border border-yellow-200 shadow-sm ml-1">
                    {{ $survey->year ?? date('Y') }}
                </span>
            </p>
        </div>

        {{-- LOGIKA WARNA & ANIMASI TIER (PHP) --}}
        @php
            $rankLabel = strtolower($survey->rank_label ?? '');
            $status = $survey->status ?? 'draft';
            $isVerified = in_array($status, ['verified', 'approved']);

            // Default Style (Fallback)
           // Default Style (Hitam & Tanpa Efek)
            $theme = [
                'card_bg'      => 'from-gray-800 to-gray-900', // Gradasi Hitam/Abu Gelap
                'text_main'    => 'text-gray-200',             // Teks Putih agak abu
                'text_sub'     => 'text-gray-500',             // Sub-teks abu gelap
                'icon_bg'      => 'bg-gray-700/50',            // Background ikon abu
                'border'       => 'border-gray-700',           // Border abu gelap
                // Matikan Animasi (Set kosong)
                'hover_shadow' => '', 
                'hover_border' => '' 
            ];

            if ($isVerified) {
                // 1. DIAMOND (Sekolah Unggul Digital) -> Ungu / Indigo Mewah
                if (str_contains($rankLabel, 'unggul') || str_contains($rankLabel, 'diamond')) {
                    $theme = [
                        'card_bg'      => 'from-indigo-600 via-purple-600 to-fuchsia-700',
                        'text_main'    => 'text-white',
                        'text_sub'     => 'text-indigo-100',
                        'icon_bg'      => 'bg-indigo-900/30',
                        'border'       => 'border-indigo-400/50',
                        // Animasi Diamond (Glow Ungu)
                        'hover_shadow' => 'hover:shadow-[0_20px_50px_-12px_rgba(147,51,234,0.6)]', 
                        'hover_border' => 'hover:border-fuchsia-300/60'
                    ];
                } 
                // 2. PLATINUM (Sekolah Maju) -> Biru Metalik / Cyan
                elseif (str_contains($rankLabel, 'maju') || str_contains($rankLabel, 'platinum')) {
                    $theme = [
                        'card_bg'      => 'from-slate-500 via-cyan-600 to-blue-700',
                        'text_main'    => 'text-white',
                        'text_sub'     => 'text-cyan-100',
                        'icon_bg'      => 'bg-cyan-800/30',
                        'border'       => 'border-cyan-400/50',
                        // Animasi Platinum (Glow Biru Muda)
                        'hover_shadow' => 'hover:shadow-[0_20px_50px_-12px_rgba(34,211,238,0.6)]',
                        'hover_border' => 'hover:border-cyan-200/60'
                    ];
                } 
                // 3. GOLD (Sekolah Berkembang) -> Emas / Amber
                elseif (str_contains($rankLabel, 'berkembang') || str_contains($rankLabel, 'gold')) {
                    $theme = [
                        'card_bg'      => 'from-yellow-600 via-amber-500 to-orange-600',
                        'text_main'    => 'text-white',
                        'text_sub'     => 'text-yellow-100',
                        'icon_bg'      => 'bg-yellow-900/30',
                        'border'       => 'border-yellow-400/50',
                        // Animasi Gold (Glow Emas)
                        'hover_shadow' => 'hover:shadow-[0_20px_50px_-12px_rgba(245,158,11,0.6)]',
                        'hover_border' => 'hover:border-yellow-200/60'
                    ];
                } 
                // 4. SILVER (Sekolah Pemula) -> Abu-abu Perak
                elseif (str_contains($rankLabel, 'pemula') || str_contains($rankLabel, 'silver')) {
                    $theme = [
                        'card_bg'      => 'from-gray-500 via-slate-500 to-zinc-600',
                        'text_main'    => 'text-white',
                        'text_sub'     => 'text-gray-200',
                        'icon_bg'      => 'bg-gray-800/30',
                        'border'       => 'border-gray-400/50',
                        // Animasi Silver (Glow Putih/Abu)
                        'hover_shadow' => 'hover:shadow-[0_20px_50px_-12px_rgba(209,213,219,0.5)]',
                        'hover_border' => 'hover:border-white/40'
                    ];
                }
            } 
        @endphp

        {{-- 2. SCORE & TIER CARD --}}
        <div class="bg-gradient-to-br {{ $theme['card_bg'] }} rounded-3xl p-8 md:p-10 shadow-2xl relative overflow-hidden group transition-all duration-500">
            
            {{-- Dekorasi Latar Belakang --}}
            <div class="absolute top-0 right-0 -mt-16 -mr-16 w-80 h-80 bg-white opacity-10 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
                
                {{-- Bagian Kiri: Skor --}}
                <div>
                    <h2 class="{{ $theme['text_sub'] }} text-xs font-bold uppercase tracking-widest mb-1">Total Skor Keamanan</h2>
                    
                    <div class="flex items-baseline justify-center md:justify-start {{ $theme['text_main'] }}">
                        <span class="text-7xl font-black tracking-tighter drop-shadow-md">
                            {{ number_format($survey->total_score ?? 0, 1) }}
                        </span>
                        <span class="text-2xl font-bold opacity-70 ml-2">/100</span>
                    </div>

                    <div class="mt-4 inline-flex items-center gap-2 bg-black/20 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/10">
                        <span class="w-2.5 h-2.5 rounded-full {{ $isVerified ? 'bg-white shadow-[0_0_10px_white]' : 'bg-slate-400' }}"></span>
                        <span class="text-xs font-bold uppercase tracking-wide text-white">
                            {{ $survey->status ?? 'Draft' }}
                        </span>
                    </div>
                </div>

                {{-- Bagian Kanan: Tampilan Tier Spesifik (ANIMASI DISINI) --}}
                @if ($isVerified)
                    <div class="flex flex-col items-center md:items-end">
                        <p class="{{ $theme['text_sub'] }} text-[10px] font-bold uppercase tracking-widest mb-4 opacity-90">
                            Predikat Pencapaian
                        </p>
                        
                        {{-- KARTU TIER ANIMASI --}}
                        {{-- 1. Group class untuk trigger hover --}}
                        {{-- 2. Transition & Duration untuk kehalusan --}}
                        {{-- 3. Hover: -translate-y-2 (Naik sedikit) --}}
                        {{-- 4. Hover: scale-105 (Membesar sedikit) --}}
                        {{-- 5. Hover: shadow & border dinamis dari PHP --}}
                        <div class="group/card relative flex items-center gap-5 bg-white/10 backdrop-blur-md px-8 py-5 rounded-2xl border {{ $theme['border'] }} shadow-lg min-w-[280px] cursor-default transition-all duration-500 ease-out hover:-translate-y-2 hover:scale-[1.03] {{ $theme['hover_shadow'] }} {{ $theme['hover_border'] }} overflow-hidden">
                            
                            {{-- Efek Kilatan Cahaya (Shine Sweep) --}}
                            <div class="absolute top-0 -left-[100%] w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent skew-x-[25deg] transition-all duration-1000 group-hover/card:left-[200%]"></div>

                            {{-- Ikon --}}
                            <div class="w-16 h-16 rounded-xl {{ $theme['icon_bg'] }} flex items-center justify-center border border-white/20 shadow-inner group-hover/card:rotate-[10deg] transition-transform duration-500">
                                <i class="bi {{ $survey->rank_icon ?? 'bi-shield-check' }} text-4xl {{ $theme['text_main'] }} drop-shadow-md"></i>
                            </div>

                            {{-- Teks --}}
                            <div class="text-left relative z-10">
                                <h3 class="text-4xl font-black uppercase tracking-tight {{ $theme['text_main'] }} drop-shadow-sm leading-none group-hover/card:scale-105 transition-transform duration-300 origin-left">
                                    {{ $survey->rank_label ?? 'N/A' }}
                                </h3>
                                <div class="h-1 w-10 bg-white/40 rounded-full mt-2 group-hover/card:w-20 transition-all duration-500"></div>
                                <p class="{{ $theme['text_main'] }} text-[10px] font-bold mt-1.5 uppercase tracking-wider opacity-90">
                                    Level Keamanan
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Tampilan Jika Belum Verifikasi --}}
                    <div class="opacity-50 p-6 border border-white/10 rounded-2xl bg-white/5 backdrop-blur-sm">
                        <i class="bi bi-lock-fill text-3xl text-white mb-2 block"></i>
                        <span class="text-xs font-bold uppercase tracking-widest text-white">Predikat Terkunci</span>
                    </div>
                @endif

            </div>
        </div>

        {{-- 3. DETAIL JAWABAN --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="bi bi-list-check text-blue-600 text-lg"></i> Rincian Jawaban
                </h3>
                <a href="{{ route('school.dashboard') }}" class="text-sm font-bold text-slate-500 hover:text-blue-600 transition-colors flex items-center gap-1">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($survey->answers as $answer)
                    <div class="p-8 hover:bg-slate-50/50 transition-colors">
                        <div class="flex gap-4 mb-4">
                            <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-xs">
                                {{ $loop->iteration }}
                            </span>
                            <p class="font-bold text-slate-800 text-base leading-relaxed pt-1">
                                {{ $answer->question->question_text }}
                            </p>
                        </div>
                        <div class="ml-12">
                            @php
                                $selectedOption = $answer->question->options->where('id', $answer->answer_value)->first();
                            @endphp
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                <div class="inline-flex items-center gap-3 px-4 py-3 bg-blue-50/50 rounded-xl border border-blue-100 text-blue-800 w-full sm:w-auto">
                                    <div class="w-5 h-5 rounded-full bg-blue-500 flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-check text-white text-sm"></i>
                                    </div>
                                    <span class="font-bold text-sm">
                                        {{ $selectedOption ? $selectedOption->option_text : 'Jawaban tidak ditemukan' }}
                                    </span>
                                </div>
                                @if ($answer->validator_note)
                                    <div class="flex items-start gap-2 text-orange-600 bg-orange-50 px-4 py-2.5 rounded-xl border border-orange-100 text-xs font-medium max-w-md">
                                        <i class="bi bi-exclamation-circle-fill mt-0.5"></i>
                                        <span>
                                            <strong class="block mb-0.5 uppercase tracking-wide text-[10px]">Catatan Validator:</strong>
                                            {{ $answer->validator_note }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-20 text-center">
                        <p class="text-slate-400">Belum ada rincian jawaban.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection