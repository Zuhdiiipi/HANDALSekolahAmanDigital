@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto">
    
    {{-- Header --}}
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Verifikasi Asesmen</h1>
            <p class="text-slate-500">Sekolah: <span class="font-bold text-blue-600">{{ $survey->school->name }}</span></p>
        </div>
        <div class="text-right">
            <div class="text-sm text-slate-400">Total Skor Mandiri</div>
            <div class="text-3xl font-bold text-emerald-600">{{ $survey->total_score }}</div>
        </div>
    </div>

    <form action="{{ route('validator.survey.store', $survey->id) }}" method="POST">
        @csrf

        <div class="space-y-8 pb-24"> {{-- Tambah padding bawah agar tidak tertutup footer --}}
            @foreach($categories as $category)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                        <h3 class="font-bold text-slate-800">{{ $category->name }}</h3>
                    </div>
                    
                    <div class="p-6 divide-y divide-slate-100">
                        @foreach($category->questions as $question)
                            @php
                                $schoolAnswer = $answers[$question->id] ?? null;
                                $selectedOptionId = $schoolAnswer ? $schoolAnswer->answer_value : null;
                            @endphp

                            <div class="py-6 first:pt-0 last:pb-0">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    
                                    {{-- KIRI: JAWABAN SEKOLAH (DISABLED) --}}
                                    <div class="opacity-75 pointer-events-none select-none bg-slate-50 p-4 rounded-xl border border-slate-200">
                                        <label class="block text-sm font-bold text-slate-500 mb-3">
                                            <i class="bi bi-person-badge mr-1"></i> Jawaban Sekolah
                                        </label>
                                        <p class="mb-3 font-medium text-slate-800">{{ $question->question_text }}</p>
                                        <ul class="space-y-2">
                                            @foreach($question->options as $option)
                                                <li class="flex items-center text-sm">
                                                    <input type="radio" {{ $selectedOptionId == $option->id ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300">
                                                    <span class="ml-2 {{ $selectedOptionId == $option->id ? 'font-bold text-blue-700' : 'text-slate-500' }}">
                                                        {{ $option->option_text }} ({{ $option->score_value }} Poin)
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    {{-- KANAN: CATATAN VERIFIKATOR --}}
                                    <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-200">
                                        <label class="block text-sm font-bold text-yellow-700 mb-3">
                                            <i class="bi bi-pencil-fill mr-1"></i> Catatan Revisi / Koreksi
                                        </label>
                                        <textarea name="notes[{{ $question->id }}]" rows="3" 
                                                  class="w-full text-sm rounded-lg border-yellow-300 focus:ring-yellow-500 focus:border-yellow-500 bg-white"
                                                  placeholder="Tulis catatan jika jawaban sekolah perlu diperbaiki...">{{ $schoolAnswer->validator_note ?? '' }}</textarea>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- STICKY FOOTER DENGAN 2 TOMBOL AKSI --}}
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 p-4 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] z-50">
            <div class="max-w-5xl mx-auto flex justify-between items-center">
                <a href="{{ route('validator.dashboard') }}" class="text-slate-500 font-bold hover:text-slate-800">
                    Batal
                </a>
                
                <div class="flex gap-3">
                    {{-- TOMBOL TOLAK / KEMBALIKAN --}}
                    <button type="submit" name="action" value="reject" 
                            class="px-6 py-3 bg-red-100 text-red-700 hover:bg-red-200 font-bold rounded-xl transition-colors border border-red-200">
                        <i class="bi bi-arrow-counterclockwise mr-2"></i> Minta Perbaikan
                    </button>

                    {{-- TOMBOL TERIMA / VERIFIKASI --}}
                    <button type="submit" name="action" value="approve" 
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg transition-colors">
                        <i class="bi bi-check-circle-fill mr-2"></i> Verifikasi Selesai
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection