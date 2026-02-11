@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- 1. HEADER SECTION --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Bank Pertanyaan</h1>
                <p class="text-slate-500 font-medium text-sm mt-1">Kelola instrumen dan indikator asesmen.</p>
            </div>
            <a href="{{ route('admin.questions.create') }}" 
               class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-indigo-200 hover:-translate-y-0.5 transition-all gap-2">
                <i class="bi bi-plus-lg text-lg"></i>
                <span>Tambah Pertanyaan</span>
            </a>
        </div>

        {{-- 2. FLASH MESSAGE --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-4 rounded-2xl mb-8 shadow-sm flex items-center gap-3 animate-fade-in-down">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-check-lg text-xl"></i>
                </div>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- 3. CONTENT AREA --}}
        <div class="space-y-8">
            @php $loopIndex = 0; @endphp
            @forelse ($questions->groupBy('category.name') as $categoryName => $categoryQuestions)
                
                {{-- Logic Warna Tema per Kategori --}}
                @php
                    $colors = [
                        ['border' => 'border-indigo-200', 'bg_header' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'icon' => 'text-indigo-500'],
                        ['border' => 'border-rose-200', 'bg_header' => 'bg-rose-50', 'text' => 'text-rose-700', 'icon' => 'text-rose-500'],
                        ['border' => 'border-amber-200', 'bg_header' => 'bg-amber-50', 'text' => 'text-amber-700', 'icon' => 'text-amber-500'],
                        ['border' => 'border-emerald-200', 'bg_header' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'icon' => 'text-emerald-500'],
                    ];
                    $theme = $colors[$loopIndex % 4];
                    $loopIndex++;
                @endphp

                <div class="bg-white rounded-3xl shadow-sm border {{ $theme['border'] }} overflow-hidden">
                    
                    {{-- Category Header --}}
                    <div class="{{ $theme['bg_header'] }} px-8 py-5 flex justify-between items-center border-b {{ $theme['border'] }}">
                        <div class="flex items-center gap-3">
                            <i class="bi bi-folder2-open text-xl {{ $theme['icon'] }}"></i>
                            <h3 class="font-extrabold text-lg {{ $theme['text'] }}">{{ $categoryName }}</h3>
                        </div>
                        <span class="px-3 py-1 bg-white/60 rounded-lg text-xs font-bold {{ $theme['text'] }} border border-white/50 backdrop-blur-sm">
                            {{ $categoryQuestions->count() }} Indikator
                        </span>
                    </div>

                    {{-- Question List --}}
                    <div class="divide-y divide-slate-100">
                        @foreach ($categoryQuestions as $q)
                            <div class="group p-6 hover:bg-slate-50/80 transition-colors flex flex-col sm:flex-row gap-5">
                                
                                {{-- Main Content --}}
                                <div class="flex-grow space-y-3">
                                    {{-- Question Text --}}
                                    <div class="flex gap-3">
                                        <span class="text-slate-300 font-black text-lg select-none">Q.</span>
                                        <p class="font-bold text-slate-800 text-base leading-relaxed">
                                            {{ $q->question_text }}
                                        </p>
                                    </div>

                                    {{-- Rubric Options (Chips) --}}
                                    @if ($q->options->count() > 0)
                                        <div class="pl-8">
                                            <div class="flex gap-2 flex-wrap">
                                                @foreach ($q->options as $opt)
                                                    <div class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs shadow-sm group-hover:border-slate-300 transition-colors">
                                                        <span class="font-black {{ $theme['text'] }} mr-2 bg-slate-50 px-1.5 rounded">
                                                            {{ $opt->score_value }}
                                                        </span>
                                                        <span class="text-slate-600 font-medium">
                                                            {{ $opt->option_text }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex sm:flex-col gap-2 items-end justify-start min-w-[40px]">
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.questions.edit', $q->id) }}"
                                       class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:shadow-sm transition-all"
                                       title="Edit Pertanyaan">
                                        <i class="bi bi-pencil-fill text-sm"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.questions.destroy', $q->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus pertanyaan ini beserta opsinya?');">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-red-600 hover:border-red-200 hover:shadow-sm transition-all"
                                                title="Hapus Pertanyaan">
                                            <i class="bi bi-trash-fill text-sm"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>

            @empty
                {{-- Empty State --}}
                <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-clipboard-x text-4xl text-slate-300"></i>
                    </div>
                    <h3 class="text-slate-900 font-bold text-lg">Belum ada pertanyaan</h3>
                    <p class="text-slate-500 text-sm mt-1 mb-6">Mulai dengan menambahkan pertanyaan ke dalam kategori.</p>
                    <a href="{{ route('admin.questions.create') }}" class="text-indigo-600 font-bold hover:underline">
                        + Buat Pertanyaan Baru
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection