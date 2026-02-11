@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- 1. HEADER SECTION --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.questions.index') }}" 
               class="group w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:bg-slate-50 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm">
                <i class="bi bi-arrow-left text-lg group-hover:-translate-x-0.5 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Tambah Pertanyaan</h1>
                <p class="text-slate-500 text-sm font-medium">Buat indikator baru untuk instrumen asesmen.</p>
            </div>
        </div>

        {{-- 2. FORM CARD --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <form action="{{ route('admin.questions.store') }}" method="POST" id="questionForm">
                @csrf

                <div class="p-8 space-y-8">
                    
                    {{-- SECTION: INFORMASI SOAL --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                <i class="bi bi-file-text-fill"></i>
                            </div>
                            <h3 class="font-bold text-slate-800">Detail Pertanyaan</h3>
                        </div>

                        {{-- Input: Kategori --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Kategori (Bab)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="bi bi-folder2-open text-slate-400"></i>
                                </div>
                                <select name="category_id" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-bold rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all appearance-none" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                    <i class="bi bi-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Input: Teks Pertanyaan --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Teks Indikator / Pertanyaan</label>
                            <div class="relative">
                                <div class="absolute top-3.5 left-0 pl-4 flex pointer-events-none">
                                    <i class="bi bi-chat-quote-fill text-slate-400"></i>
                                </div>
                                <textarea name="question_text" rows="3" 
                                    class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-bold rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-slate-400"
                                    placeholder="Contoh: Bagaimana persentase kelulusan peserta mikroskill?" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-100"></div>

                    {{-- SECTION: RUBRIK --}}
                    <div>
                        <div class="flex justify-between items-end mb-6">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center">
                                    <i class="bi bi-list-check"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800">Rubrik Penilaian</h3>
                                    <p class="text-xs text-slate-400">Definisikan opsi jawaban dan bobot nilai.</p>
                                </div>
                            </div>
                            <button type="button" onclick="addOption()"
                                class="text-xs font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3 py-2 rounded-lg transition-colors flex items-center gap-1">
                                <i class="bi bi-plus-lg"></i> Tambah Opsi
                            </button>
                        </div>

                        {{-- Container Opsi --}}
                        <div id="options-container" class="space-y-3">
                            {{-- Default 5 Opsi --}}
                            @for ($i = 0; $i < 5; $i++)
                                <div class="option-row group flex gap-3 items-start bg-slate-50 p-2 rounded-2xl border border-slate-200 hover:border-indigo-200 transition-colors">
                                    {{-- Drag/Number Handle (Visual) --}}
                                    <div class="w-10 h-[46px] flex items-center justify-center bg-white rounded-xl border border-slate-200 text-slate-400 font-bold text-sm shadow-sm">
                                        {{ $i + 1 }}
                                    </div>

                                    {{-- Input Teks --}}
                                    <div class="flex-grow">
                                        <input type="text" name="options[{{ $i }}][text]" 
                                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-slate-400"
                                            placeholder="Keterangan opsi jawaban..." required>
                                    </div>

                                    {{-- Input Score --}}
                                    <div class="w-24 relative" title="Nilai Poin">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i class="bi bi-star-fill text-[10px]"></i>
                                        </div>
                                        <input type="number" name="options[{{ $i }}][score]" value="{{ $i + 1 }}"
                                            class="w-full pl-8 pr-3 py-3 bg-white border border-slate-200 rounded-xl text-sm font-bold text-center focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" required>
                                    </div>

                                    {{-- Delete Button --}}
                                    <button type="button" onclick="removeOption(this)" 
                                        class="w-[46px] h-[46px] flex items-center justify-center rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 border border-transparent hover:border-red-100 transition-all">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            @endfor
                        </div>
                    </div>

                </div>

                {{-- FOOTER ACTION --}}
                <div class="bg-slate-50 px-8 py-5 border-t border-slate-200 flex justify-end gap-3">
                    <a href="{{ route('admin.questions.index') }}" 
                        class="px-6 py-3 rounded-xl text-sm font-bold text-slate-500 hover:text-slate-700 hover:bg-slate-200/50 transition-all">
                        Batal
                    </a>
                    <button type="submit" 
                        class="inline-flex items-center justify-center px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:-translate-y-0.5 transition-all gap-2">
                        <i class="bi bi-save"></i>
                        <span>Simpan Pertanyaan</span>
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- JAVASCRIPT --}}
    <script>
        let optionIndex = 5; 

        function addOption() {
            const container = document.getElementById('options-container');
            const currentCount = container.children.length + 1;

            const html = `
            <div class="option-row group flex gap-3 items-start bg-slate-50 p-2 rounded-2xl border border-slate-200 hover:border-indigo-200 transition-colors animate-fade-in">
                <div class="w-10 h-[46px] flex items-center justify-center bg-white rounded-xl border border-slate-200 text-slate-400 font-bold text-sm shadow-sm">
                    ${currentCount}
                </div>
                <div class="flex-grow">
                    <input type="text" name="options[${optionIndex}][text]" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-slate-400" placeholder="Keterangan opsi jawaban..." required>
                </div>
                <div class="w-24 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="bi bi-star-fill text-[10px]"></i>
                    </div>
                    <input type="number" name="options[${optionIndex}][score]" value="${currentCount}" class="w-full pl-8 pr-3 py-3 bg-white border border-slate-200 rounded-xl text-sm font-bold text-center focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" required>
                </div>
                <button type="button" onclick="removeOption(this)" class="w-[46px] h-[46px] flex items-center justify-center rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 border border-transparent hover:border-red-100 transition-all">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            optionIndex++;
        }

        function removeOption(button) {
            button.closest('.option-row').remove();
            // Opsional: Re-order nomor urut visual jika diperlukan
        }
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
    </style>
@endsection