@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto">

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">Halo, {{ Auth::user()->name }}</h1>
            <p class="text-slate-500">Selamat datang di panel evaluasi keamanan digital sekolah.</p>
        </div>

        {{-- BANNER STATUS UTAMA --}}
        {{-- Warna Background: Hijau jika Verified/Approved, Biru jika Submitted/Draft/Belum Mulai --}}
        <div
            class="bg-gradient-to-r {{ in_array($surveyStatus, ['verified', 'approved']) ? 'from-emerald-600 to-teal-700' : 'from-blue-600 to-indigo-700' }} rounded-3xl p-8 md:p-12 text-white shadow-xl mb-10 relative overflow-hidden group">

            {{-- Dekorasi Background --}}
            <div
                class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-10 rounded-full group-hover:scale-110 transition-transform duration-500">
            </div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>

            <div class="relative z-10 text-center">

                {{-- KONDISI 1: SUDAH DIVERIFIKASI (TAMPILKAN SKOR) --}}
                @if (in_array($surveyStatus, ['verified', 'approved']))
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Hasil Asesmen</h2>
                    <p class="text-emerald-100 text-lg mb-6 max-w-2xl mx-auto">
                        Selamat! Berikut adalah predikat keamanan digital sekolah Anda berdasarkan verifikasi validator.
                    </p>

                    <div class="mb-8">
                        <div
                            class="inline-flex flex-col items-center justify-center p-6 bg-white rounded-3xl shadow-2xl animate-fade-in-up relative overflow-hidden">

                            {{-- Label Status --}}
                            <div
                                class="absolute top-0 right-0 bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-bl-xl shadow-sm">
                                <i class="bi bi-check-circle-fill mr-1"></i> Terverifikasi
                            </div>

                            {{-- Icon Peringkat --}}
                            <div
                                class="w-20 h-20 flex items-center justify-center rounded-full mb-4 {{ $currentSurvey->rank_color }}">
                                <i class="bi {{ $currentSurvey->rank_icon }} text-4xl"></i>
                            </div>

                            {{-- Nama Peringkat --}}
                            <h3 class="text-2xl font-bold text-slate-800 mb-1">
                                {{ $currentSurvey->rank_label }}
                            </h3>

                            {{-- Skor Nilai --}}
                            <p class="text-slate-500 font-medium">
                                Skor Akhir: <span
                                    class="text-blue-600 font-bold text-xl">{{ number_format($currentSurvey->total_score, 1) }}</span>
                                / 100
                            </p>

                            <div class="mt-4">
                                <a href="{{ route('school.survey.result', $currentSurvey->id) }}"
                                    class="text-sm font-bold text-blue-600 hover:underline">
                                    Lihat Rincian Poin
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- KONDISI 2: SUDAH SUBMIT TAPI BELUM DIVERIFIKASI (SEMBUNYIKAN SKOR) --}}
                @elseif ($surveyStatus === 'submitted')
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Terima Kasih!</h2>
                    <p class="text-blue-100 text-lg mb-6 max-w-2xl mx-auto">
                        Asesmen Anda telah kami terima dan sedang dalam antrean verifikasi.
                    </p>

                    <div class="mb-8">
                        <div
                            class="inline-flex flex-col items-center justify-center p-8 bg-white/95 backdrop-blur rounded-3xl shadow-xl">

                            {{-- Icon Jam Pasir --}}
                            <div
                                class="w-20 h-20 flex items-center justify-center rounded-full bg-orange-100 text-orange-500 mb-4">
                                <i class="bi bi-hourglass-split text-4xl"></i>
                            </div>

                            <h3 class="text-2xl font-bold text-slate-800 mb-2">
                                Menunggu Verifikasi
                            </h3>

                            <p class="text-slate-500 text-center text-sm max-w-xs leading-relaxed">
                                Tim validator sedang memeriksa jawaban dan bukti dukung Anda.<br>
                                <span class="font-bold text-slate-600">Skor dan Predikat akan muncul setelah
                                    diverifikasi.</span>
                            </p>
                        </div>
                    </div>

                    {{-- KONDISI 3: MASIH DRAFT (LANJUTKAN) --}}
                @elseif($surveyStatus === 'draft')
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Lanjutkan Asesmen?</h2>
                    <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                        Anda memiliki pengisian yang belum selesai. Lanjutkan untuk menyelesaikan.
                    </p>

                    <a href="{{ route('school.survey.start') }}"
                        class="inline-flex items-center bg-yellow-400 text-yellow-900 hover:bg-yellow-300 px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                        <i class="bi bi-play-circle-fill mr-3"></i> Lanjutkan Pengisian
                    </a>

                    {{-- KONDISI 4: BELUM MULAI --}}
                @else
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Siap Mengukur Keamanan Digital?</h2>
                    <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                        Isi instrumen survei terbaru untuk mengetahui indeks keamanan sekolah Anda dan dapatkan rekomendasi
                        perbaikan.
                    </p>

                    <a href="{{ route('school.survey.start') }}"
                        class="inline-flex items-center bg-white text-blue-700 hover:text-blue-800 px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <i class="bi bi-play-circle-fill mr-3 text-2xl"></i>
                        Mulai Survei Baru
                    </a>
                @endif

            </div>
        </div>

        {{-- TABEL RIWAYAT EVALUASI --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-bold text-slate-700">Riwayat Evaluasi Lengkap</h3>
                <span class="text-xs text-slate-400">Total: {{ $historySurveys->count() }} Data</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold">
                        <tr>
                            <th class="px-6 py-4">Tahun</th>
                            <th class="px-6 py-4 text-center">Skor</th>
                            <th class="px-6 py-4 text-center">Predikat</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($historySurveys as $history)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-700">
                                    {{ $history->year }}
                                </td>

                                {{-- Kolom Skor --}}
                                <td class="px-6 py-4 text-center">
                                    @if (in_array($history->status, ['verified', 'approved']))
                                        <span
                                            class="font-bold text-blue-600">{{ number_format($history->total_score, 1) }}</span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>

                                {{-- Kolom Predikat --}}
                                <td class="px-6 py-4 text-center">
                                    @if (in_array($history->status, ['verified', 'approved']))
                                        <span
                                            class="text-xs font-semibold px-2 py-1 rounded border {{ $history->rank_color }}">
                                            {{ $history->rank_label }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>

                                {{-- Kolom Status --}}
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="text-xs font-bold uppercase {{ in_array($history->status, ['verified', 'approved']) ? 'text-emerald-600' : ($history->status == 'submitted' ? 'text-orange-500' : 'text-slate-500') }}">
                                        {{ $history->status }}
                                    </span>
                                </td>

                                {{-- Kolom Aksi --}}
                                <td class="px-6 py-4 text-right">
                                    @if (in_array($history->status, ['submitted', 'verified', 'approved']))
                                        <a href="{{ route('school.survey.result', $history->id) }}"
                                            class="text-sm font-bold text-blue-600 hover:text-blue-800 hover:underline">
                                            Lihat Detail
                                        </a>
                                    @elseif($history->status == 'draft' && $history->year == date('Y'))
                                        <a href="{{ route('school.survey.start') }}"
                                            class="text-sm font-bold text-yellow-600 hover:text-yellow-800 hover:underline">
                                            Lanjutkan
                                        </a>
                                    @else
                                        <span class="text-slate-400 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="bi bi-clipboard-data text-4xl text-slate-300 mb-3"></i>
                                        <p>Belum ada riwayat survei.</p>
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
