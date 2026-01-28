@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">Halo, {{ Auth::user()->name }} </h1>
            <p class="text-slate-500">Selamat datang di panel evaluasi keamanan digital sekolah.</p>
        </div>

        <div class="relative z-10 text-center">

            @if ($surveyStatus === 'submitted')
                {{-- KONDISI 1: SUDAH SUBMIT --}}
                <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Terima Kasih!</h2>
                <p class="text-emerald-100 text-lg mb-8 max-w-2xl mx-auto">
                    Anda telah menyelesaikan Asesmen Mandiri tahun ini. Skor keamanan sekolah Anda saat ini adalah:
                </p>

                <div class="text-5xl font-bold mb-8 bg-white/20 inline-block px-8 py-4 rounded-2xl backdrop-blur-sm">
                    {{ number_format($currentSurvey->total_score ?? 0, 0) }}
                </div>

                <div class="flex flex-col gap-3 justify-center items-center">
                    <button disabled
                        class="inline-flex items-center bg-white/50 cursor-not-allowed text-white px-8 py-3 rounded-full font-bold text-lg">
                        <i class="bi bi-check-circle-fill mr-3"></i> Data Terkunci
                    </button>
                    <p class="text-xs text-emerald-100 opacity-80">
                        Ingin mengedit jawaban? Silakan hubungi Verifikator/Admin.
                    </p>
                </div>
            @elseif($surveyStatus === 'draft')
                {{-- KONDISI 2: MASIH DRAFT (BELUM SELESAI) --}}
                <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Lanjutkan Asesmen?</h2>
                <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                    Anda memiliki pengisian yang belum selesai. Lanjutkan untuk mendapatkan skor.
                </p>
                <a href="{{ route('school.survey.start') }}"
                    class="inline-flex items-center bg-yellow-400 text-yellow-900 hover:bg-yellow-300 px-8 py-4 rounded-full font-bold text-lg shadow-lg transition-all">
                    <i class="bi bi-play-circle-fill mr-3"></i> Lanjutkan Pengisian
                </a>
            @else
                {{-- KONDISI 3: BELUM MULAI (NONE) --}}
                <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Siap Mengukur Keamanan?</h2>
                <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                    Lakukan Asesmen Mandiri untuk mengetahui indeks keamanan digital sekolah Anda.
                </p>
                <a href="{{ route('school.survey.start') }}"
                    class="inline-flex items-center bg-white text-blue-700 hover:text-blue-800 px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                    <i class="bi bi-clipboard-check-fill mr-3"></i> Asesmen Mandiri
                </a>
            @endif

        </div>
        {{-- INI --}}

        <div
            class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 md:p-12 text-white shadow-xl mb-10 relative overflow-hidden group">
            <div
                class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-10 rounded-full group-hover:scale-110 transition-transform duration-500">
            </div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>

            <div class="relative z-10 text-center">
                <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Siap Mengukur Keamanan Digital?</h2>
                <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                    Isi instrumen survei terbaru untuk mengetahui indeks keamanan sekolah Anda dan dapatkan rekomendasi
                    perbaikan secara instan.
                </p>

                <a href="{{ route('school.survey.start') }}"
                    class="inline-flex items-center bg-white text-blue-700 hover:text-blue-800 px-8 py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <i class="bi bi-play-circle-fill mr-3 text-2xl"></i>
                    Mulai Survei Baru
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-bold text-slate-700">Riwayat Evaluasi Terakhir</h3>
                <span class="text-xs text-slate-400">Menampilkan 1 data terakhir</span>
            </div>
            <div class="p-6 text-center text-slate-500">
                <div class="py-8">
                    <i class="bi bi-clipboard-data text-4xl text-slate-300 mb-3 block"></i>
                    <p>Belum ada riwayat survei.</p>
                </div>
            </div>
        </div>

    </div>
@endsection
