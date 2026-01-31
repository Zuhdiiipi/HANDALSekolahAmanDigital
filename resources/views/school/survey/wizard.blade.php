@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">

        {{-- Progress Bar (Header) --}}
        <div class="mb-8">
            <div class="flex justify-between text-sm font-medium text-slate-500 mb-2">
                <span>Langkah {{ $currentStep }} dari {{ $totalSteps }}</span>
                <span>{{ $category->name }}</span>
            </div>
            <div class="w-full bg-slate-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500"
                    style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
            <div class="bg-slate-50 px-8 py-6 border-b border-slate-100">
                <h2 class="text-xl font-bold text-slate-800">{{ $category->name }}</h2>
            </div>

            <form action="{{ route('school.survey.process', $currentStep) }}" method="POST" class="p-8">
                @csrf

                <div class="space-y-10">
                    @forelse($questions as $index => $question)
                        @php
                            // Ambil data jawaban lama dari controller
                            $myAnswer = $existingAnswers[$question->id] ?? null;

                            // Ambil ID opsi yang dipilih (untuk radio button)
                            $savedValue = $myAnswer ? $myAnswer->answer_value : null;

                            // Ambil catatan validator (untuk alert merah)
                            $note = $myAnswer ? $myAnswer->validator_note : null;
                        @endphp

                        <div class="pb-6 border-b border-slate-50 last:border-0">

                            {{-- Teks Pertanyaan --}}
                            <label class="block text-base font-bold text-slate-800 mb-4">
                                {{ $loop->iteration }}. {{ $question->question_text }}
                            </label>

                            {{-- ALERT KHUSUS JIKA ADA REVISI --}}
                            @if ($note)
                                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg animate-pulse">
                                    <div class="flex items-start">
                                        <i class="bi bi-exclamation-circle-fill text-red-500 mt-0.5 mr-3"></i>
                                        <div>
                                            <h3 class="text-sm font-bold text-red-800">Perlu Revisi:</h3>
                                            <p class="text-sm text-red-700 mt-1">"{{ $note }}"</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Pilihan Jawaban --}}
                            <div class="space-y-3">
                                @foreach ($question->options as $option)
                                    <label
                                        class="flex items-center p-4 border rounded-xl cursor-pointer transition-all duration-200 group
                                {{-- KONDISI CSS: Jika ini jawaban yang tersimpan, beri warna biru --}}
                                {{ $savedValue == $option->id ? 'bg-blue-50 border-blue-500 shadow-sm' : 'border-slate-200 hover:bg-slate-50 hover:border-slate-300' }}">

                                        <input type="radio" name="answers[{{ $question->id }}]"
                                            value="{{ $option->id }}" class="w-5 h-5 text-blue-600 focus:ring-blue-500"
                                            {{-- LOGIKA UTAMA: Check otomatis jika value sama dengan database --}} {{ $savedValue == $option->id ? 'checked' : '' }}
                                            required>

                                        <span
                                            class="ml-3 text-sm font-medium {{ $savedValue == $option->id ? 'text-blue-700' : 'text-slate-700' }}">
                                            {{ $option->option_text }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                    @empty
                        <p class="text-center text-slate-400">Tidak ada pertanyaan di kategori ini.</p>
                    @endforelse
                </div>

                <div class="mt-8 flex justify-between items-center pt-6 border-t border-slate-100">
                    @if ($currentStep > 1)
                        <a href="{{ route('school.survey.step', $currentStep - 1) }}"
                            class="text-slate-500 font-bold hover:text-slate-800 px-4 py-2 rounded-lg hover:bg-slate-100 transition-colors">
                            <i class="bi bi-arrow-left mr-2"></i> Sebelumnya
                        </a>
                    @else
                        <div></div>
                    @endif

                    <button type="submit"
                        class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-blue-700 hover:-translate-y-1 transition-all">
                        {{ $currentStep == $totalSteps ? 'Selesai & Hitung Skor' : 'Simpan & Lanjut' }} <i
                            class="bi bi-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
