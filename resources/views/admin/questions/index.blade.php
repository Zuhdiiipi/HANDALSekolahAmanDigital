@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Bank Pertanyaan</h1>
            <p class="text-slate-500">Kelola Instrumen Asesmen Sekolah</p>
        </div>
        <a href="{{ route('admin.questions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg transition-all flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Tambah Pertanyaan
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl mb-6 border border-emerald-100 font-bold">
            <i class="bi bi-check-circle-fill mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="space-y-8">
        @foreach($questions->groupBy('category.name') as $categoryName => $categoryQuestions)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800">{{ $categoryName }}</h3>
                    <span class="text-xs font-bold bg-slate-200 text-slate-600 px-2 py-1 rounded">
                        {{ $categoryQuestions->count() }} Soal
                    </span>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach($categoryQuestions as $q)
                        <div class="p-6 hover:bg-slate-50 transition-colors flex gap-4">
                            <div class="flex-grow">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                                        {{ strtoupper($q->type) }}
                                    </span>
                                    <span class="text-xs font-bold text-slate-500">Bobot: {{ $q->weight }}%</span>
                                </div>
                                <p class="font-medium text-slate-800">{{ $q->question_text }}</p>
                                
                                {{-- Preview Opsi (Hanya 3 pertama) --}}
                                @if($q->options->count() > 0)
                                    <div class="mt-3 flex gap-2 flex-wrap">
                                        @foreach($q->options->take(3) as $opt)
                                            <span class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded border border-slate-200">
                                                {{ $opt->option_text }} ({{ $opt->score_value }})
                                            </span>
                                        @endforeach
                                        @if($q->options->count() > 3)
                                            <span class="text-xs text-slate-400 px-1">+{{ $q->options->count() - 3 }} lainnya</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('admin.questions.edit', $q->id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-200 transition-colors">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('admin.questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?');">
                                    @csrf @method('DELETE')
                                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-red-600 hover:border-red-200 transition-colors">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection