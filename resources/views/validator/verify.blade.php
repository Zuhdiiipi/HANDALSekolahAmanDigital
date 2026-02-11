@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto pb-32"> {{-- Tambah padding bawah agar tidak tertutup sticky footer --}}

        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <a href="{{ route('validator.dashboard') }}" class="text-sm text-slate-500 hover:text-blue-600 mb-2 inline-block">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <h1 class="text-2xl font-bold text-slate-800">Verifikasi Asesmen</h1>
                <p class="text-slate-500">Sekolah: <span class="font-bold text-blue-600">{{ $survey->school->name }}</span>
                </p>
            </div>
            <div class="bg-white px-5 py-3 rounded-xl border border-slate-200 shadow-sm text-right">
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Skor Sementara</div>
                <div class="text-3xl font-bold text-emerald-600">{{ number_format($survey->total_score, 1) }}</div>
            </div>
        </div>

        <form action="{{ route('validator.survey.store', $survey->id) }}" method="POST">
            @csrf

            <div class="space-y-8">
                @foreach ($categories as $category)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="font-bold text-slate-800">{{ $category->name }}</h3>
                            <span class="text-xs font-semibold bg-slate-200 text-slate-600 px-2 py-1 rounded">
                                {{ $category->questions->count() }} Soal
                            </span>
                        </div>

                        <div class="p-6 space-y-8">
                            @foreach ($category->questions as $question)
                                @php
                                    $schoolAnswer = $answers[$question->id] ?? null;
                                    $selectedOptionId = $schoolAnswer ? $schoolAnswer->answer_value : null;
                                @endphp

                                <div class="pb-6 border-b border-slate-100 last:border-0 last:pb-0">
                                    <h4 class="text-base font-bold text-slate-800 mb-4">
                                        {{ $loop->iteration }}. {{ $question->question_text }}
                                    </h4>

                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                        
                                        {{-- KOLOM KIRI (2/3): OPSI JAWABAN (RADIO BUTTON) --}}
                                        <div class="lg:col-span-2 space-y-3">
                                            @foreach ($question->options as $option)
                                                @php
                                                    $isChosen = $selectedOptionId == $option->id;
                                                @endphp

                                                <label class="relative flex items-start p-3 border rounded-xl cursor-pointer transition-all group
                                                    {{ $isChosen ? 'bg-blue-50 border-blue-500 ring-1 ring-blue-500 z-10' : 'border-slate-200 hover:bg-slate-50 hover:border-blue-300' }}">
                                                    
                                                    <div class="flex items-center h-5">
                                                        {{-- RADIO BUTTON: Name array disesuaikan dengan Controller --}}
                                                        <input type="radio" 
                                                               name="validation[{{ $question->id }}][answer_id]" 
                                                               value="{{ $option->id }}"
                                                               class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                                               {{ $isChosen ? 'checked' : '' }}>
                                                    </div>
                                                    
                                                    <div class="ml-3 w-full">
                                                        <div class="flex justify-between">
                                                            <span class="text-sm font-medium {{ $isChosen ? 'text-blue-800' : 'text-slate-700' }}">
                                                                {{ $option->option_text }}
                                                            </span>
                                                            <span class="text-xs font-bold {{ $isChosen ? 'text-blue-600' : 'text-slate-400' }}">
                                                                {{ $option->score_value }} Poin
                                                            </span>
                                                        </div>
                                                        
                                                        {{-- Label Penanda Jawaban Asli Sekolah --}}
                                                        @if($isChosen)
                                                            <div class="mt-1">
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-700">
                                                                    <i class="bi bi-person-check-fill mr-1"></i> Pilihan Sekolah
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>

                                        {{-- KOLOM KANAN (1/3): CATATAN VALIDATOR --}}
                                        <div class="lg:col-span-1">
                                            <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-200 h-full">
                                                <label class="block text-xs font-bold text-yellow-700 uppercase tracking-wide mb-2">
                                                    <i class="bi bi-pencil-square mr-1"></i> Catatan Koreksi
                                                </label>
                                                <textarea name="validation[{{ $question->id }}][note]" rows="4"
                                                    class="w-full text-sm rounded-lg border-yellow-300 focus:ring-yellow-500 focus:border-yellow-500 bg-white placeholder-yellow-300/50"
                                                    placeholder="Berikan alasan jika Anda mengubah nilai...">{{ $schoolAnswer->validator_note ?? '' }}</textarea>
                                                <p class="text-[10px] text-yellow-600 mt-2 leading-tight">
                                                    *Jika Anda mengubah opsi di samping, wajib berikan alasan di sini.
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- STICKY FOOTER --}}
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 p-4 shadow-[0_-4px_20px_rgba(0,0,0,0.1)] z-40">
                <div class="max-w-5xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-xs text-slate-500 hidden md:block">
                        <i class="bi bi-info-circle mr-1"></i> Pastikan semua jawaban telah diperiksa sebelum memverifikasi.
                    </div>

                    <div class="flex w-full md:w-auto gap-3">
                        {{-- TOMBOL KEMBALIKAN (REJECT) --}}
                        <button type="submit" name="action" value="reject"
                            class="flex-1 md:flex-none px-6 py-3 bg-white border-2 border-red-100 text-red-600 hover:bg-red-50 hover:border-red-200 font-bold rounded-xl transition-colors">
                            <i class="bi bi-arrow-counterclockwise mr-2"></i> Minta Revisi
                        </button>

                        {{-- TOMBOL VERIFIKASI (APPROVE) --}}
                        <button type="submit" name="action" value="approve"
                            class="flex-1 md:flex-none px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 hover:shadow-xl hover:-translate-y-0.5 transition-all">
                            <i class="bi bi-check-circle-fill mr-2"></i> Simpan & Verifikasi
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection