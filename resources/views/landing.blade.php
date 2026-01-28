@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-10 md:p-16 text-center mb-10">
        <span class="inline-block px-4 py-2 mb-6 rounded-full bg-blue-50 text-blue-600 font-bold text-sm tracking-wide">
            BBPSDM Komdigi Makassar
        </span>

        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 mb-6 tracking-tight">
            Handal Sekolah <span class="text-blue-600">Aman Digital</span>
        </h1>

        <p class="text-lg md:text-xl text-slate-500 max-w-3xl mx-auto leading-relaxed mb-8">
            Pemeringkatan Sekolah Aman Digital (HANDAL) terhadap Sekolah Menengah di Sulawesi Selatan
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-12">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">

            <div
                class="group bg-white rounded-2xl p-8 border border-slate-100 shadow-sm border-t-4 border-t-blue-500 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 ease-out">
                <div class="flex flex-col items-center text-center h-full">
                    <div
                        class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-6 text-blue-600 group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-file-earmark-text-fill text-4xl"></i>
                    </div>

                    <h3 class="text-2xl font-bold text-slate-800 mb-3">Pendaftaran & Asesmen Sekolah</h3>
                    <p class="text-slate-500 mb-8 px-4">
                        Sekolah dapat mendaftar untuk mengikuti asesmen. Setelah disetujui admin, mereka dapat mengisi kuesioner.
                    </p>

                    <a href="{{ route('registration.page') }}"
                        class="mt-auto block w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full shadow-md hover:shadow-lg transition-all duration-200">
                        Daftar Sekolah
                    </a>
                </div>
            </div>

            <div
                class="group bg-white rounded-2xl p-8 border border-slate-100 shadow-sm border-t-4 border-t-emerald-500 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 ease-out">
                <div class="flex flex-col items-center text-center h-full">
                    <div
                        class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mb-6 text-emerald-600 group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-bar-chart-line-fill text-4xl"></i>
                    </div>

                    <h3 class="text-2xl font-bold text-slate-800 mb-3">Peringkat Sekolah</h3>
                    <p class="text-slate-500 mb-8 px-4">
                        Publik dapat melihat data ranking sekolah yang diperbaharui secara berkala berdasarkan hasil asesmen.
                    </p>

                    <a href="{{ route('ranking.page') }}"
                        class="mt-auto block w-full py-3 px-6 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-full shadow-md hover:shadow-lg transition-all duration-200">
                        Lihat Ranking Sekolah
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
