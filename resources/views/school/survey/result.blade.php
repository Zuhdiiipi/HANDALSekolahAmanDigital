@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">

        {{-- Header Hasil --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full mb-4">
                <i class="bi bi-trophy-fill text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-slate-800">Hasil Asesmen Mandiri</h1>
            <p class="text-slate-500 mt-2">Tahun {{ $survey->year }}</p>
        </div>

        {{-- Kartu Skor Utama --}}
        <div
            class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-8 text-white shadow-xl mb-8 flex flex-col md:flex-row items-center justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-48 h-48 bg-white opacity-5 rounded-full blur-3xl"></div>

            <div class="relative z-10 mb-6 md:mb-0 text-center md:text-left">
                <h2 class="text-2xl font-bold mb-1">Total Skor Keamanan</h2>
                <p class="text-slate-400 text-sm">Status: <span
                        class="text-emerald-400 font-bold uppercase">{{ $survey->status }}</span></p>
            </div>

            <div
                class="relative z-10 text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">
                {{ number_format($survey->total_score, 0) }}
            </div>
        </div>

        {{-- Detail Jawaban (Opsional) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="font-bold text-slate-700">Ringkasan Jawaban</h3>
                <a href="{{ route('school.dashboard') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800">
                    Kembali ke Dashboard
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($survey->answers as $answer)
                    <div class="p-6 hover:bg-slate-50 transition-colors">
                        <p class="text-sm font-bold text-slate-500 mb-2">
                            Pertanyaan #{{ $loop->iteration }}
                        </p>
                        <p class="font-medium text-slate-800 mb-3">
                            {{ $answer->question->question_text }}
                        </p>

                        {{-- Tampilkan Opsi yang dipilih --}}
                        @php
                            // Cari teks opsi yang dipilih
                            $selectedOption = $answer->question->options->where('id', $answer->answer_value)->first();
                        @endphp

                        <div class="flex items-center gap-2">
                            <i class="bi bi-check-circle-fill text-blue-600"></i>
                            <span
                                class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg text-sm font-bold border border-blue-100">
                                {{ $selectedOption ? $selectedOption->option_text : 'Jawaban tidak ditemukan' }}
                            </span>

                            {{-- Jika ada catatan validator --}}
                            @if ($answer->validator_note)
                                <div
                                    class="ml-auto flex items-center gap-2 text-orange-600 bg-orange-50 px-3 py-1 rounded-lg border border-orange-100">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    <span class="text-xs font-bold">Catatan: {{ $answer->validator_note }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400">
                        Tidak ada data jawaban detail.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection
