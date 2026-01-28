@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    
    <div class="mb-8">
        <div class="flex justify-between text-sm font-medium text-slate-500 mb-2">
            <span>Langkah {{ $currentStep }} dari {{ $totalSteps }}</span>
            <span>{{ $category->name }}</span>
        </div>
        <div class="w-full bg-slate-200 rounded-full h-2.5">
            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
        <div class="bg-slate-50 px-8 py-6 border-b border-slate-100">
            <h2 class="text-xl font-bold text-slate-800">{{ $category->name }}</h2>
            <p class="text-slate-500 text-sm">Bobot Kategori: {{ $category->weight }}%</p>
        </div>

        <form action="{{ route('school.survey.process', $currentStep) }}" method="POST" class="p-8">
            @csrf
            
            <div class="space-y-8">
                @forelse($questions as $index => $question)
                    <div class="pb-6 border-b border-slate-50 last:border-0">
                        <label class="block text-base font-semibold text-slate-800 mb-3">
                            {{ $loop->iteration }}. {{ $question->question_text }}
                        </label>
                        
                        <div class="space-y-2">
                            @foreach($question->options as $option)
                            <label class="flex items-center p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition-colors">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="w-5 h-5 text-blue-600 focus:ring-blue-500" required>
                                <span class="ml-3 text-slate-700">{{ $option->option_text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-center text-red-500">Belum ada pertanyaan untuk kategori ini.</p>
                @endforelse
            </div>

            <div class="mt-8 flex justify-between items-center">
                @if($currentStep > 1)
                    <a href="{{ route('school.survey.step', $currentStep - 1) }}" class="text-slate-500 font-bold hover:text-slate-800">
                        <i class="bi bi-arrow-left"></i> Sebelumnya
                    </a>
                @else
                    <div></div> 
                @endif

                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-blue-700 hover:-translate-y-1 transition-all">
                    {{ $currentStep == $totalSteps ? 'Selesai & Hitung Skor' : 'Lanjut' }} <i class="bi bi-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection