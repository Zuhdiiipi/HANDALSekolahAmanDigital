@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- 1. HEADER SECTION --}}
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Halo, {{ Auth::user()->name }} 👋</h1>
            <p class="text-slate-500 font-medium">Selamat datang di panel evaluasi keamanan digital sekolah.</p>
        </div>

        {{-- LOGIKA TEMA (WARNA & ANIMASI) --}}
        @php
            $rankLabel = strtolower($currentSurvey->rank_label ?? '');
            $status = $surveyStatus ?? 'draft';
            $isVerified = in_array($status, ['verified', 'approved']);

            // Elemen Animasi Shine (Kilatan Cahaya) - Dipakai berulang
            $shineEffect = '<div class="absolute top-0 -left-[100%] w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent skew-x-[25deg] transition-all duration-1000 group-hover/shine:left-[200%]"></div>';

            // Default (Draft/Submitted)
            $theme = [
                'bg_gradient'  => 'from-blue-600 to-indigo-700',
                'card_border'  => 'border-white/10',
                'text_accent'  => 'text-blue-100',
                'icon_bg'      => 'bg-blue-800/30',
                'anim_class'   => '',
                'decor_element'=> ''
            ];

            if ($isVerified) {
                // 1. DIAMOND (Sekolah Unggul) -> UNGU + SHINE + STARS
                if (str_contains($rankLabel, 'unggul') || str_contains($rankLabel, 'diamond')) {
                    $theme = [
                        'bg_gradient'  => 'from-indigo-600 via-purple-600 to-fuchsia-700',
                        'card_border'  => 'border-indigo-400/50',
                        'text_accent'  => 'text-indigo-100',
                        'icon_bg'      => 'bg-indigo-900/30',
                        // Shadow Ungu
                        'anim_class'   => 'hover:shadow-[0_10px_40px_rgba(168,85,247,0.6)] relative overflow-hidden group/shine hover:-translate-y-1 transition-all duration-500',
                        // Decor: Shine + Bintang
                        'decor_element'=> $shineEffect . '<div class="absolute top-2 right-4 text-white/70 animate-[ping_2s_infinite]"><i class="bi bi-star-fill text-[8px]"></i></div>'
                    ];
                } 
                // 2. PLATINUM (Sekolah Maju) -> CYAN + SHINE
                elseif (str_contains($rankLabel, 'maju') || str_contains($rankLabel, 'platinum')) {
                    $theme = [
                        'bg_gradient'  => 'from-slate-500 via-cyan-600 to-blue-700',
                        'card_border'  => 'border-cyan-400/50',
                        'text_accent'  => 'text-cyan-100',
                        'icon_bg'      => 'bg-cyan-800/30',
                        // Shadow Cyan/Biru Muda
                        'anim_class'   => 'hover:shadow-[0_10px_40px_rgba(34,211,238,0.6)] relative overflow-hidden group/shine hover:-translate-y-1 transition-all duration-500',
                        'decor_element'=> $shineEffect
                    ];
                } 
                // 3. GOLD (Sekolah Berkembang) -> EMAS + SHINE
                elseif (str_contains($rankLabel, 'berkembang') || str_contains($rankLabel, 'gold')) {
                    $theme = [
                        'bg_gradient'  => 'from-yellow-600 via-amber-500 to-orange-600',
                        'card_border'  => 'border-yellow-400/50',
                        'text_accent'  => 'text-yellow-100',
                        'icon_bg'      => 'bg-yellow-900/30',
                        // Shadow Emas/Amber
                        'anim_class'   => 'hover:shadow-[0_10px_40px_rgba(245,158,11,0.6)] relative overflow-hidden group/shine hover:-translate-y-1 transition-all duration-500',
                        'decor_element'=> $shineEffect
                    ];
                } 
                // 4. SILVER (Sekolah Pemula) -> PERAK + SHINE
                elseif (str_contains($rankLabel, 'pemula') || str_contains($rankLabel, 'silver')) {
                    $theme = [
                        'bg_gradient'  => 'from-gray-500 via-slate-500 to-zinc-600',
                        'card_border'  => 'border-gray-400/50',
                        'text_accent'  => 'text-gray-200',
                        'icon_bg'      => 'bg-gray-800/30',
                        // Shadow Putih/Abu
                        'anim_class'   => 'hover:shadow-[0_10px_40px_rgba(226,232,240,0.5)] relative overflow-hidden group/shine hover:-translate-y-1 transition-all duration-500',
                        'decor_element'=> $shineEffect
                    ];
                }
                // 5. GAGAL -> HITAM (TIDAK ADA ANIMASI)
                elseif (str_contains($rankLabel, 'gagal')) {
                    $theme = [
                        'bg_gradient'  => 'from-gray-900 via-slate-900 to-black',
                        'card_border'  => 'border-gray-700',
                        'text_accent'  => 'text-gray-400',
                        'icon_bg'      => 'bg-gray-800',
                        'anim_class'   => '', // Statis
                        'decor_element'=> ''  // Tidak ada shine
                    ];
                }
                // Fallback (Emerald)
                else {
                    $theme = [
                        'bg_gradient'  => 'from-emerald-600 to-teal-700',
                        'card_border'  => 'border-emerald-500/30',
                        'text_accent'  => 'text-emerald-100',
                        'icon_bg'      => 'bg-emerald-800/30',
                        'anim_class'   => '',
                        'decor_element'=> ''
                    ];
                }
            }
        @endphp

        {{-- 2. BANNER STATUS UTAMA --}}
        <div class="bg-gradient-to-r {{ $theme['bg_gradient'] }} rounded-3xl p-8 md:p-12 text-white shadow-xl mb-10 relative overflow-hidden group transition-all duration-500">
            
            {{-- Dekorasi Background Umum --}}
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-10 rounded-full group-hover:scale-110 transition-transform duration-700 ease-out"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>

            <div class="relative z-10 text-center">

                {{-- KONDISI A: SUDAH DIVERIFIKASI (TIER CARD) --}}
                @if ($isVerified)
                    <h2 class="text-3xl font-extrabold mb-3">Hasil Asesmen</h2>
                    <p class="{{ $theme['text_accent'] }} text-lg mb-6 max-w-2xl mx-auto">
                        Selamat! Berikut adalah predikat keamanan digital sekolah Anda berdasarkan verifikasi validator.
                    </p>

                    <div class="mb-6 flex justify-center">
                        {{-- KARTU TIER UTAMA --}}
                        <div class="inline-flex flex-col items-center justify-center p-6 bg-white/10 backdrop-blur-md rounded-3xl border {{ $theme['card_border'] }} shadow-lg text-white relative min-w-[300px] cursor-default {{ $theme['anim_class'] }}">
                            
                            {{-- Decor Element (Shine / Stars) --}}
                            {!! $theme['decor_element'] !!}

                            {{-- Label Verified --}}
                            <div class="absolute top-0 right-0 bg-white/20 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl shadow-sm uppercase tracking-wider backdrop-blur-sm z-10">
                                <i class="bi bi-patch-check-fill mr-1"></i> Verified
                            </div>

                            {{-- Ikon Tier --}}
                            <div class="w-20 h-20 flex items-center justify-center rounded-full mb-3 {{ $theme['icon_bg'] }} border border-white/20 shadow-inner z-10 relative">
                                @if(str_contains($rankLabel, 'gagal'))
                                    <i class="bi bi-x-circle text-4xl text-gray-500"></i>
                                @else
                                    <i class="bi {{ $currentSurvey->rank_icon ?? 'bi-shield' }} text-4xl drop-shadow-md"></i>
                                @endif
                            </div>

                            {{-- Nama Peringkat --}}
                            <h3 class="text-3xl font-black mb-1 uppercase tracking-tight drop-shadow-md z-10 relative">{{ $currentSurvey->rank_label ?? '-' }}</h3>

                            {{-- Skor Nilai --}}
                            <p class="text-white/80 text-xs font-bold uppercase tracking-widest mb-3 z-10 relative">Skor Akhir</p>
                            <span class="text-5xl font-black text-white drop-shadow-lg z-10 relative">{{ number_format($currentSurvey->total_score, 1) }}</span>
                            
                            <div class="mt-6 w-full z-10 relative">
                                <a href="{{ route('school.survey.result', $currentSurvey->id) }}" class="block w-full py-2.5 rounded-xl bg-white text-slate-800 font-bold text-sm hover:bg-slate-100 transition-colors shadow-sm">
                                    Lihat Rincian
                                </a>
                            </div>
                        </div>
                    </div>

                {{-- KONDISI B: SUDAH SUBMIT --}}
                @elseif ($surveyStatus === 'submitted')
                    <div class="flex flex-col items-center py-4">
                        <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mb-6 backdrop-blur-sm shadow-sm">
                            <i class="bi bi-hourglass-split text-4xl text-white"></i>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-extrabold mb-3">Menunggu Verifikasi</h2>
                        <p class="text-blue-100 text-lg mb-8 max-w-xl mx-auto leading-relaxed">
                            Asesmen Anda sedang ditinjau oleh tim validator. Skor dan sertifikat akan muncul setelah proses selesai.
                        </p>
                        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 px-6 py-3 rounded-2xl text-sm font-medium shadow-sm cursor-default">
                            <span>Status:</span>
                            <span class="font-bold text-yellow-300 tracking-wide">Dalam Antrean</span>
                        </div>
                    </div>

                {{-- KONDISI C: MASIH DRAFT --}}
                @elseif($surveyStatus === 'draft')
                    <h2 class="text-3xl font-extrabold mb-4">Lanjutkan Asesmen?</h2>
                    <p class="text-blue-100 text-lg mb-8 max-w-xl mx-auto">
                        Anda memiliki pengisian yang belum selesai. Segera lengkapi data untuk mengetahui status keamanan sekolah.
                    </p>
                    <a href="{{ route('school.survey.start') }}" class="inline-flex items-center bg-yellow-400 text-yellow-900 hover:bg-yellow-300 px-8 py-3.5 rounded-full font-bold text-lg shadow-lg hover:-translate-y-1 transition-all">
                        <i class="bi bi-play-circle-fill mr-2"></i> Lanjutkan Pengisian
                    </a>

                {{-- KONDISI D: BELUM MULAI --}}
                @else
                    <h2 class="text-3xl font-extrabold mb-4">Siap Mengukur Keamanan?</h2>
                    <p class="text-blue-100 text-lg mb-8 max-w-xl mx-auto">
                        Isi instrumen survei terbaru untuk mengetahui indeks keamanan sekolah Anda dan dapatkan rekomendasi perbaikan.
                    </p>
                    <a href="{{ route('school.survey.start') }}" class="inline-flex items-center bg-white text-blue-700 hover:bg-blue-50 px-8 py-3.5 rounded-full font-bold text-lg shadow-lg hover:-translate-y-1 transition-all">
                        <i class="bi bi-rocket-takeoff-fill mr-3"></i> Mulai Survei Baru
                    </a>
                @endif

            </div>
        </div>

        {{-- 3. TABEL RIWAYAT EVALUASI --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            
            {{-- Header Tabel --}}
            <div class="px-8 py-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-clock-history text-blue-600"></i> Riwayat Evaluasi
                    </h3>
                    <p class="text-slate-500 text-sm mt-1">Rekam jejak asesmen keamanan digital sekolah.</p>
                </div>
                <div class="bg-slate-50 px-4 py-2 rounded-xl text-xs font-bold text-slate-500 border border-slate-200">
                    Total: <span class="text-slate-800">{{ $historySurveys->count() }}</span> Data
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            <th class="px-8 py-5">Periode & ID</th>
                            <th class="px-6 py-5 text-center">Skor Akhir</th>
                            <th class="px-6 py-5 text-center">Predikat</th>
                            <th class="px-6 py-5 text-center">Status</th>
                            <th class="px-8 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($historySurveys as $history)
                            <tr class="group hover:bg-slate-50/60 transition-colors duration-200">
                                <td class="px-8 py-5 align-middle">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 text-slate-700 flex flex-col items-center justify-center shadow-sm group-hover:border-blue-200 group-hover:text-blue-600 transition-colors">
                                            <span class="text-[10px] font-bold uppercase tracking-wide text-slate-400">THN</span>
                                            <span class="font-black text-sm">{{ $history->year }}</span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 text-sm group-hover:text-blue-600 transition-colors">Evaluasi Tahunan</p>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-[11px] font-mono text-slate-400 bg-slate-100 px-1.5 rounded border border-slate-200">#{{ $history->id }}</span>
                                                <span class="text-[11px] text-slate-400">{{ $history->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 align-middle text-center">
                                    @if (in_array($history->status, ['verified', 'approved']))
                                        <div class="inline-flex flex-col items-center">
                                            <span class="text-xl font-black text-slate-800 tracking-tight">{{ number_format($history->total_score, 1) }}</span>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase">Poin</span>
                                        </div>
                                    @else
                                        <span class="text-slate-300 font-bold text-xl select-none">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 align-middle text-center">
                                    @if (in_array($history->status, ['verified', 'approved']))
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-[11px] font-bold border shadow-sm {{ $history->rank_color ?? 'bg-slate-100 text-slate-600 border-slate-200' }}">
                                            @if($history->rank_icon) <i class="bi {{ $history->rank_icon }} mr-1.5"></i> @endif
                                            {{ $history->rank_label ?? 'N/A' }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs italic">Menunggu hasil</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 align-middle text-center">
                                    @php
                                        $statusConfig = [
                                            'draft'     => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'border' => 'border-slate-200', 'icon' => 'bi-pencil', 'label' => 'Draft'],
                                            'submitted' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'border' => 'border-blue-200', 'icon' => 'bi-send-fill', 'label' => 'Diajukan'],
                                            'verified'  => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-200', 'icon' => 'bi-patch-check-fill', 'label' => 'Terverifikasi'],
                                            'approved'  => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-200', 'icon' => 'bi-check-circle-fill', 'label' => 'Selesai'],
                                            'rejected'  => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'border' => 'border-red-200', 'icon' => 'bi-x-circle-fill', 'label' => 'Ditolak'],
                                        ];
                                        $config = $statusConfig[$history->status] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-500', 'border' => 'border-gray-200', 'icon' => 'bi-question-circle', 'label' => ucfirst($history->status)];
                                    @endphp
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                        <i class="bi {{ $config['icon'] }}"></i> {{ $config['label'] }}
                                    </div>
                                </td>
                                <td class="px-8 py-5 align-middle text-right">
                                    @if (in_array($history->status, ['submitted', 'verified', 'approved']))
                                        <a href="{{ route('school.survey.result', $history->id) }}" class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-500 text-xs font-bold hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all shadow-sm group-hover:shadow-md gap-2">
                                            <i class="bi bi-eye-fill"></i> Detail
                                        </a>
                                    @elseif($history->status == 'draft' && $history->year == date('Y'))
                                        <a href="{{ route('school.survey.start') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-amber-400 text-amber-900 text-xs font-bold hover:bg-amber-300 hover:shadow-md transition-all shadow-sm gap-2">
                                            <i class="bi bi-play-fill text-sm"></i> Lanjutkan
                                        </a>
                                    @else
                                        <span class="text-slate-300 text-xl select-none">•</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                                            <i class="bi bi-clipboard-x text-3xl text-slate-300"></i>
                                        </div>
                                        <h3 class="text-slate-900 font-bold text-sm">Belum ada riwayat</h3>
                                        <p class="text-slate-500 text-xs mt-1">Sekolah ini belum pernah melakukan evaluasi keamanan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($historySurveys->count() > 0)
                <div class="bg-slate-50/50 px-8 py-4 border-t border-slate-200 flex items-center justify-center md:justify-end">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                        Handal School Assessment System
                    </p>
                </div>
            @endif
        </div>

    </div>
@endsection