@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Edit Pertanyaan</h1>
            <a href="{{ route('admin.questions.index') }}" class="text-slate-500 hover:text-slate-800">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- BAGIAN 1: DETAIL PERTANYAAN --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-6">
                <h3 class="font-bold text-slate-700 mb-4 border-b pb-2">Informasi Soal</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-2">Kategori (Bab)</label>
                        <select name="category_id" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ $question->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-2">Teks Pertanyaan / Indikator</label>
                        <textarea name="question_text" rows="3" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required>{{ $question->question_text }}</textarea>
                    </div>
                </div>
            </div>

            {{-- BAGIAN 2: OPSI JAWABAN --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-6">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="font-bold text-slate-700">Rubrik Penilaian</h3>
                    <button type="button" onclick="addOption()"
                        class="text-sm bg-blue-50 text-blue-600 px-3 py-1 rounded-lg font-bold hover:bg-blue-100">
                        <i class="bi bi-plus-lg"></i> Tambah Opsi
                    </button>
                </div>

                <div id="options-container" class="space-y-4">
                    @foreach ($question->options as $index => $option)
                        <div class="option-row flex gap-4 items-start bg-slate-50 p-3 rounded-xl border border-slate-200">
                            <div class="flex-grow">
                                <label class="text-xs font-bold text-slate-500 block mb-1">Keterangan Rubrik</label>
                                <input type="text" name="options[{{ $index }}][text]"
                                    value="{{ $option->option_text }}" class="w-full rounded-lg border-slate-300 text-sm"
                                    required>
                            </div>

                            <div class="w-10">
                                <label class="text-xs font-bold text-slate-500 block mb-1">Poin</label>
                                <input type="number" name="options[{{ $index }}][score]"
                                    value="{{ $option->score_value }}"
                                    class="w-full rounded-lg border-slate-300 text-sm font-bold text-center" required>
                            </div>
                            <div class="w-10">
                                <label class="text-xs font-bold text-slate-500 block mb-1">Aksi</label>
                                <button type="button" onclick="removeOption(this)"
                                    class="text-red-500 hover:text-red-700"><i class="bi bi-trash-fill"></i></button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.questions.index') }}" class="px-6 py-3 font-bold text-slate-500">Batal</a>
                <button type="submit"
                    class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700">
                    Perbarui Pertanyaan
                </button>
            </div>
        </form>
    </div>

    <script>
        let optionIndex = {{ $question->options->count() + 1 }};

        function addOption() {
            const container = document.getElementById('options-container');
            const html = `
            <div class="option-row flex gap-4 items-start bg-slate-50 p-3 rounded-xl border border-slate-200 animate-fade-in">
                <div class="flex-grow">
                    <input type="text" name="options[${optionIndex}][text]" class="w-full rounded-lg border-slate-300 text-sm" placeholder="Opsi Baru..." required>
                </div>
                <div class="w-24">
                    <input type="number" name="options[${optionIndex}][score]" class="w-full rounded-lg border-slate-300 text-sm font-bold text-center" placeholder="Poin" required>
                </div>
                <div class="pt-1">
                    <button type="button" onclick="removeOption(this)" class="text-red-500 hover:text-red-700 p-2"><i class="bi bi-trash-fill"></i></button>
                </div>
            </div>`;
            container.insertAdjacentHTML('beforeend', html);
            optionIndex++;
        }

        function removeOption(button) {
            button.closest('.option-row').remove();
        }
    </script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
@endsection
