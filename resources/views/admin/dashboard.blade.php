@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">

        <div class="mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800">Dashboard Admin</h1>
                <p class="text-slate-500 mt-1">Ringkasan aktivitas sistem Handal Sekolah.</p>
            </div>
            <div class="text-sm text-slate-400 font-medium bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm">
                <i class="bi bi-calendar3 mr-2"></i> {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden group hover:border-blue-300 transition-all">
                <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                    <i class="bi bi-person-plus-fill text-6xl text-blue-600"></i>
                </div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Siap Terbit Akun</p>
                <h3 class="text-3xl font-extrabold text-blue-600 mb-2">{{ $stats['waiting_for_account'] }}</h3>
                @if ($stats['waiting_for_account'] > 0)
                    <a href="{{ route('admin.registrations.index') }}"
                        class="text-xs font-bold text-blue-500 hover:text-blue-700 flex items-center">
                        Proses Sekarang <i class="bi bi-arrow-right ml-1"></i>
                    </a>
                @else
                    <span class="text-xs text-slate-400 flex items-center"><i class="bi bi-check-circle mr-1"></i> Semua
                        selesai</span>
                @endif
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute right-0 top-0 p-4 opacity-10">
                    <i class="bi bi-building-check text-6xl text-emerald-600"></i>
                </div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Sekolah Aktif</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mb-2">{{ $stats['active_schools'] }}</h3>
                <p class="text-xs text-slate-400">Akun sekolah yang telah dibuat.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute right-0 top-0 p-4 opacity-10">
                    <i class="bi bi-hourglass-split text-6xl text-orange-500"></i>
                </div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Antrian Validator</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mb-2">{{ $stats['pending_validator'] }}</h3>
                <p class="text-xs text-slate-400">Sedang diperiksa validator.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute right-0 top-0 p-4 opacity-10">
                    <i class="bi bi-x-circle text-6xl text-red-500"></i>
                </div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Ditolak</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mb-2">{{ $stats['rejected'] }}</h3>
                <p class="text-xs text-slate-400">Total pengajuan ditolak.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800">Pendaftaran Terbaru</h3>
                        <span class="text-xs bg-slate-100 text-slate-500 px-2 py-1 rounded">5 Terakhir</span>
                    </div>
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-500">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Sekolah</th>
                                <th class="px-6 py-3 font-semibold">Tgl Daftar</th>
                                <th class="px-6 py-3 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentRegistrations as $reg)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-slate-700">
                                        {{ $reg->school_name }}
                                        <div class="text-xs text-slate-400 font-normal">{{ $reg->npsn }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $reg->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($reg->status == 'verified')
                                            <span
                                                class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-bold">Siap
                                                Terbit</span>
                                        @elseif($reg->status == 'pending')
                                            <span
                                                class="bg-orange-100 text-orange-700 px-2 py-1 rounded-full text-xs font-bold">Verifikasi</span>
                                        @elseif($reg->status == 'approved')
                                            <span
                                                class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-bold">Selesai</span>
                                        @else
                                            <span
                                                class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-bold">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-slate-400">Belum ada data
                                        pendaftaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-lg overflow-hidden text-white">
                    <div class="px-6 py-5 border-b border-slate-700 flex items-center">
                        <i class="bi bi-trophy-fill text-yellow-400 mr-3"></i>
                        <h3 class="font-bold">Top Sekolah Handal</h3>
                    </div>
                    <div class="p-4 space-y-4">
                        @forelse($topSchools as $index => $school)
                            <div
                                class="flex items-center p-3 rounded-xl bg-white/10 hover:bg-white/20 transition-colors cursor-default">
                                <div
                                    class="w-8 h-8 flex items-center justify-center font-bold {{ $index == 0 ? 'text-yellow-400' : 'text-slate-300' }}">
                                    #{{ $loop->iteration }}
                                </div>
                                <div class="ml-3 flex-1 min-w-0">
                                    <p class="text-sm font-bold truncate">{{ $school->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $school->city }}</p>
                                </div>
                                <div class="font-mono font-bold text-emerald-400">
                                    {{ number_format($school->current_score ?? 0, 0) }}
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-slate-500 text-sm">
                                Belum ada skor survei.
                            </div>
                        @endforelse
                    </div>
                    <div class="px-6 py-4 bg-black/20 text-center">
                        <a href="{{ route('ranking.page') }}"
                            class="text-xs font-bold text-slate-300 hover:text-white transition-colors">
                            Lihat Ranking Lengkap <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
