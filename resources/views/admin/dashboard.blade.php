@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- 1. HEADER SECTION --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h4 class="text-slate-500 font-bold text-xs uppercase tracking-widest mb-1">Dashboard Overview</h4>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Halo, Admin Handal</h1>
            </div>
            <div class="flex items-center gap-3 bg-white px-5 py-2.5 rounded-full border border-slate-200 shadow-sm text-sm text-slate-600">
                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i class="bi bi-calendar-day-fill"></i>
                </div>
                <span class="font-bold text-slate-700">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
        </div>

        {{-- 2. STATS GRID (Dengan Border Warna di Kiri) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

            {{-- Card 1: Pendaftaran Baru (Biru) --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 border-l-[6px] border-l-blue-500 transition-transform hover:-translate-y-1 duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pendaftaran Baru</p>
                        <h3 class="text-4xl font-black text-slate-800 mt-2">{{ $stats['waiting_for_account'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                        <i class="bi bi-person-plus-fill text-2xl"></i>
                    </div>
                </div>
                
                @if ($stats['waiting_for_account'] > 0)
                    <a href="{{ route('admin.registrations.index') }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 mt-1">
                        Proses Data <i class="bi bi-arrow-right ml-1"></i>
                    </a>
                @else
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold mt-1">
                        <i class="bi bi-check-circle-fill"></i> Semua selesai
                    </div>
                @endif
            </div>

            {{-- Card 2: Sekolah Aktif (Hijau) --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 border-l-[6px] border-l-emerald-500 transition-transform hover:-translate-y-1 duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sekolah Aktif</p>
                        <h3 class="text-4xl font-black text-slate-800 mt-2">{{ $stats['active_schools'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                        <i class="bi bi-building-check text-2xl"></i>
                    </div>
                </div>
                <p class="text-xs text-slate-400 font-medium">Total akun terdaftar</p>
            </div>

            {{-- Card 3: Dalam Proses (Oranye) --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 border-l-[6px] border-l-orange-400 transition-transform hover:-translate-y-1 duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Dalam Proses</p>
                        <h3 class="text-4xl font-black text-slate-800 mt-2">{{ $stats['pending_validator'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center">
                        <i class="bi bi-hourglass-split text-2xl"></i>
                    </div>
                </div>
                <p class="text-xs text-slate-400 font-medium">Sedang diverifikasi</p>
            </div>

            {{-- Card 4: Ditolak (Merah) --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 border-l-[6px] border-l-red-500 transition-transform hover:-translate-y-1 duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ditolak</p>
                        <h3 class="text-4xl font-black text-slate-800 mt-2">{{ $stats['rejected'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-red-50 text-red-500 rounded-xl flex items-center justify-center">
                        <i class="bi bi-x-octagon text-2xl"></i>
                    </div>
                </div>
                <p class="text-xs text-slate-400 font-medium">Tidak memenuhi syarat</p>
            </div>

        </div>

        {{-- 3. CONTENT SPLIT --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- MAIN COLUMN: TABEL PENDAFTARAN --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
                        <div>
                            <h3 class="font-bold text-slate-800">Aktivitas Pendaftaran</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Pantau status pendaftaran terbaru.</p>
                        </div>
                        <a href="{{ route('admin.registrations.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition-colors">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-white text-slate-400 text-[11px] uppercase font-bold tracking-wider border-b border-slate-100">
                                <tr>
                                    <th class="pl-8 pr-4 py-4">Sekolah</th>
                                    <th class="px-4 py-4">Waktu</th>
                                    <th class="px-4 py-4 text-right pr-8">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($recentRegistrations as $reg)
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="pl-8 pr-4 py-4">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                                    {{ substr($reg->school_name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="font-bold text-slate-700 group-hover:text-blue-600 transition-colors">{{ $reg->school_name }}</p>
                                                    <div class="flex items-center gap-2 mt-0.5">
                                                        <span class="text-[10px] font-mono text-slate-400 bg-slate-100 px-1.5 rounded">{{ $reg->npsn }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex flex-col">
                                                <span class="text-xs font-semibold text-slate-600">{{ $reg->created_at->format('d M Y') }}</span>
                                                <span class="text-[10px] text-slate-400">{{ $reg->created_at->diffForHumans() }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-right pr-8">
                                            @php
                                                $statusConfig = [
                                                    'verified' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'dot' => 'bg-blue-500', 'label' => 'Siap Terbit'],
                                                    'pending'  => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-200', 'dot' => 'bg-orange-500', 'label' => 'Verifikasi'],
                                                    'approved' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500', 'label' => 'Selesai'],
                                                    'rejected' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'dot' => 'bg-red-500', 'label' => 'Ditolak'],
                                                ];
                                                $config = $statusConfig[$reg->status] ?? ['bg' => 'bg-slate-50', 'text' => 'text-slate-600', 'border' => 'border-slate-200', 'dot' => 'bg-slate-400', 'label' => $reg->status];
                                            @endphp
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-bold border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $config['dot'] }}"></span>
                                                {{ $config['label'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-16 text-center text-slate-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mb-2">
                                                    <i class="bi bi-inbox text-slate-300 text-xl"></i>
                                                </div>
                                                <p class="text-xs">Tidak ada data terbaru.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- SIDEBAR: TOP SCHOOLS --}}
            <div class="lg:col-span-1">
                <div class="bg-slate-900 rounded-3xl shadow-xl shadow-slate-200 overflow-hidden text-white h-full relative border border-slate-800">
                    
                    {{-- Glow Effect --}}
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-600 rounded-full blur-[80px] opacity-20"></div>
                    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-purple-600 rounded-full blur-[80px] opacity-20"></div>

                    <div class="relative z-10">
                        <div class="px-6 py-6 border-b border-white/10 flex items-center justify-between">
                            <h3 class="font-bold flex items-center gap-2">
                                <div class="p-1.5 bg-yellow-500/20 rounded-lg">
                                    <i class="bi bi-trophy-fill text-yellow-400 text-sm"></i>
                                </div>
                                Top Schools
                            </h3>
                            <a href="{{ route('ranking.page') }}" class="text-[10px] font-bold text-slate-400 hover:text-white bg-white/5 hover:bg-white/10 px-3 py-1.5 rounded-lg transition-all">LIHAT SEMUA</a>
                        </div>
                        
                        <div class="p-4 space-y-2">
                            @forelse($topSchools as $index => $school)
                                <div class="flex items-center p-3 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 hover:border-white/10 hover:scale-[1.02] transition-all cursor-default group">
                                    {{-- Rank --}}
                                    <div class="relative w-10 h-10 flex items-center justify-center">
                                        @if($index == 0)
                                            <i class="bi bi-star-fill text-yellow-400 text-xs absolute -top-1 -right-1 animate-spin-slow"></i>
                                        @endif
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center font-black text-sm 
                                            {{ $index == 0 ? 'bg-yellow-400 text-yellow-900' : 
                                              ($index == 1 ? 'bg-slate-300 text-slate-800' : 
                                              ($index == 2 ? 'bg-orange-400 text-orange-900' : 'bg-slate-800 text-slate-400')) }}">
                                            {{ $loop->iteration }}
                                        </div>
                                    </div>
                                    
                                    {{-- Info --}}
                                    <div class="ml-3 flex-1 min-w-0">
                                        <p class="text-sm font-bold truncate text-slate-200 group-hover:text-white transition-colors">{{ $school->name }}</p>
                                        <div class="flex items-center gap-1 text-[10px] text-slate-500">
                                            <i class="bi bi-geo-alt"></i> {{ $school->city }}
                                        </div>
                                    </div>
                                    
                                    {{-- Score --}}
                                    <div class="flex flex-col items-end">
                                        <span class="text-[10px] text-slate-500 font-bold uppercase">Skor</span>
                                        <span class="font-mono font-bold text-emerald-400">{{ number_format($school->current_score ?? 0, 0) }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-12 text-slate-500">
                                    <i class="bi bi-bar-chart text-2xl mb-2 opacity-50"></i>
                                    <p class="text-xs">Belum ada skor.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection