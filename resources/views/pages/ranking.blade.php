@extends('layouts.app')

@section('title', 'Leaderboard Sekolah Aman')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">

        {{-- BREADCRUMB --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol
                class="inline-flex items-center space-x-2 text-sm text-slate-500 bg-white px-4 py-2 rounded-full border border-slate-100 shadow-sm">
                <li><a href="/" class="hover:text-blue-600 transition-colors font-medium"><i
                            class="bi bi-house-door-fill mr-1"></i> Beranda</a></li>
                <li class="text-slate-300">/</li>
                <li class="font-bold text-blue-600" aria-current="page">Leaderboard</li>
            </ol>
        </nav>

        {{-- HEADER --}}
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3 tracking-tight">
                Peringkat Sekolah <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Aman Digital</span>
            </h1>
            <p class="text-slate-500 max-w-2xl mx-auto">
                Apresiasi untuk sekolah yang berkomitmen tinggi dalam menciptakan ekosistem digital yang aman dan
                terpercaya.
            </p>
        </div>

        {{-- TOP 3 PODIUM (Hanya Tampil Jika Data >= 3) --}}
        @if ($rankings->count() >= 3)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 items-end">

                {{-- Juara 2 --}}
                <div
                    class="order-2 md:order-1 bg-white rounded-2xl shadow-lg border border-slate-100 p-6 flex flex-col items-center relative transform hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="absolute -top-5 w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center border-4 border-slate-50 shadow-md">
                        <span class="font-bold text-slate-600">2</span>
                    </div>
                    <div
                        class="w-20 h-20 bg-slate-100 rounded-full mb-4 flex items-center justify-center text-2xl font-bold text-slate-500 shadow-inner">
                        {{ substr($rankings[1]->name, 0, 1) }}
                    </div>
                    <h3
                        class="font-bold text-slate-800 text-center mb-1 line-clamp-2 h-12 flex items-center justify-center">
                        {{ $rankings[1]->name }}</h3>
                    <div
                        class="bg-slate-50 text-slate-700 px-4 py-1.5 rounded-full font-bold text-sm border border-slate-200 mt-2">
                        {{ number_format($rankings[1]->current_score, 2) }}
                    </div>
                </div>

                {{-- Juara 1 --}}
                <div
                    class="order-1 md:order-2 bg-gradient-to-b from-white to-yellow-50 rounded-2xl shadow-xl border-t-4 border-yellow-400 p-8 flex flex-col items-center relative transform scale-105 z-10">
                    <div class="absolute -top-8">
                        <i class="bi bi-trophy-fill text-5xl text-yellow-400 drop-shadow-md"></i>
                    </div>
                    <div
                        class="w-24 h-24 bg-yellow-100 rounded-full mb-4 flex items-center justify-center text-3xl font-bold text-yellow-600 shadow-inner mt-4 border-4 border-white">
                        {{ substr($rankings[0]->name, 0, 1) }}
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-lg text-center mb-1">{{ $rankings[0]->name }}</h3>
                    <p class="text-xs text-yellow-600 font-bold uppercase tracking-wider mb-3">Juara Keamanan Digital</p>
                    <div
                        class="bg-yellow-400 text-white px-6 py-2 rounded-full font-bold text-lg shadow-lg shadow-yellow-200">
                        {{ number_format($rankings[0]->current_score, 2) }}
                    </div>
                </div>

                {{-- Juara 3 --}}
                <div
                    class="order-3 md:order-3 bg-white rounded-2xl shadow-lg border border-slate-100 p-6 flex flex-col items-center relative transform hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="absolute -top-5 w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center border-4 border-slate-50 shadow-md">
                        <span class="font-bold text-orange-700">3</span>
                    </div>
                    <div
                        class="w-20 h-20 bg-orange-50 rounded-full mb-4 flex items-center justify-center text-2xl font-bold text-orange-400 shadow-inner">
                        {{ substr($rankings[2]->name, 0, 1) }}
                    </div>
                    <h3
                        class="font-bold text-slate-800 text-center mb-1 line-clamp-2 h-12 flex items-center justify-center">
                        {{ $rankings[2]->name }}</h3>
                    <div
                        class="bg-slate-50 text-slate-700 px-4 py-1.5 rounded-full font-bold text-sm border border-slate-200 mt-2">
                        {{ number_format($rankings[2]->current_score, 2) }}
                    </div>
                </div>

            </div>
        @endif

        {{-- LIST TABLE --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-700">Daftar Peringkat Lengkap</h3>
                <span class="text-xs font-medium text-slate-400 bg-white px-3 py-1 rounded-full border border-slate-200">
                    Total {{ $rankings->count() }} Sekolah
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead
                        class="bg-white text-xs text-slate-400 uppercase tracking-wider font-bold border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 w-20 text-center">Rank</th>
                            <th class="px-6 py-4">Nama Sekolah</th>
                            <th class="px-6 py-4 text-center">Skor Keamanan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($rankings as $index => $school)
                            <tr class="hover:bg-blue-50/30 transition-colors duration-200 group">

                                {{-- Kolom Peringkat --}}
                                <td class="px-6 py-4 text-center">
                                    @if ($index == 0)
                                        <i class="bi bi-trophy-fill text-yellow-400 text-xl drop-shadow-sm"></i>
                                    @elseif($index == 1)
                                        <div
                                            class="w-8 h-8 rounded-full bg-slate-200 text-slate-600 font-bold flex items-center justify-center mx-auto text-sm">
                                            2</div>
                                    @elseif($index == 2)
                                        <div
                                            class="w-8 h-8 rounded-full bg-orange-100 text-orange-700 font-bold flex items-center justify-center mx-auto text-sm">
                                            3</div>
                                    @else
                                        <span class="font-bold text-slate-400">#{{ $index + 1 }}</span>
                                    @endif
                                </td>

                                {{-- Kolom Nama --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shadow-sm
                                        {{ $index == 0
                                            ? 'bg-yellow-100 text-yellow-700'
                                            : ($index == 1
                                                ? 'bg-slate-100 text-slate-600'
                                                : ($index == 2
                                                    ? 'bg-orange-50 text-orange-600'
                                                    : 'bg-white border border-slate-100 text-slate-400')) }}">
                                            {{ substr($school->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div
                                                class="font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                                                {{ $school->name }}</div>
                                            <div class="text-xs text-slate-400">Terverifikasi</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kolom Skor --}}
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold shadow-sm
                                    {{ $index == 0
                                        ? 'bg-yellow-100 text-yellow-700 border border-yellow-200'
                                        : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }}">
                                        {{ number_format($school->current_score, 2) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                            <i class="bi bi-bar-chart-line text-2xl text-slate-300"></i>
                                        </div>
                                        <p class="text-slate-500 font-medium">Belum ada data ranking tersedia.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
