@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Tambah Pertanyaan Baru</h1>
            <a href="{{ route('admin.questions.index') }}" class="text-slate-500 hover:text-slate-800">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.questions.store') }}" method="POST" id="questionForm">
            @csrf

            {{-- BAGIAN 1: DETAIL PERTANYAAN --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-6">
                <h3 class="font-bold text-slate-700 mb-4 border-b pb-2">Informasi Soal</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-600 mb-2">Kategori (Bab)</label>
                        <select name="category_id" class="w-full rounded-lg border-slate-300 focus:ring-blue-500" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }} (Bobot Bab: {{ $cat->weight }}%)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-2">Tipe Soal</label>
                        <select name="type" id="typeSelect" onchange="toggleOptions()"
                            class="w-full rounded-lg border-slate-300" required>
                            <option value="mcq">Pilihan Ganda (MCQ)</option>
                            <option value="text">Isian Singkat (Text)</option>
                            <option value="checkbox">Checkbox</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-2">Bobot Soal (%)</label>
                        <input type="number" step="0.1" name="weight"
                            class="w-full rounded-lg border-slate-300 focus:ring-blue-500" placeholder="Contoh: 10"
                            required>
                        <p class="text-xs text-slate-400 mt-1">Bobot pertanyaan ini dalam bab tersebut.</p>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block text-sm font-bold text-slate-600 mb-2">Teks Pertanyaan</label>
                    <textarea name="question_text" rows="3" class="w-full rounded-lg border-slate-300 focus:ring-blue-500"
                        placeholder="Tulis pertanyaan lengkap..." required></textarea>
                </div>
            </div>

            {{-- BAGIAN 2: OPSI JAWABAN DINAMIS --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-6">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="font-bold text-slate-700">Opsi Jawaban & Skor</h3>
                    <button type="button" onclick="addOption()"
                        class="text-sm bg-blue-50 text-blue-600 px-3 py-1 rounded-lg font-bold hover:bg-blue-100">
                        <i class="bi bi-plus-lg"></i> Tambah Opsi
                    </button>
                </div>

                {{-- Container tempat Opsi muncul --}}
                <div id="options-container" class="space-y-4">
                    {{-- Default muncul 2 opsi awal --}}
                    @for ($i = 0; $i < 2; $i++)
                        <div class="option-row flex gap-4 items-start bg-slate-50 p-3 rounded-xl border border-slate-200">
                            <div class="flex-grow">
                                <label class="text-xs font-bold text-slate-500 block mb-1">Teks Opsi</label>
                                <input type="text" name="options[{{ $i }}][text]"
                                    class="w-full rounded-lg border-slate-300 text-sm"
                                    placeholder="Contoh: Sangat Baik / Ya" required>
                            </div>
                            <div class="w-24">
                                <label class="text-xs font-bold text-slate-500 block mb-1">Nilai</label>
                                <input type="number" name="options[{{ $i }}][score]"
                                    class="w-full rounded-lg border-slate-300 text-sm" placeholder="0-100" required>
                            </div>
                            @if ($i > 0)
                                <div class="pt-6">
                                    <button type="button" onclick="removeOption(this)"
                                        class="text-red-500 hover:text-red-700"><i class="bi bi-trash-fill"></i></button>
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <button type="reset" class="px-6 py-3 font-bold text-slate-500">Reset</button>
                <button type="submit"
                    class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700">
                    Simpan Pertanyaan
                </button>
            </div>
        </form>
    </div>

    {{-- SCRIPT JAVASCRIPT UNTUK MENAMBAH OPSI --}}
    <script>
        let optionIndex = 2; // Mulai dari index 2 karena 0 dan 1 sudah ada default

        function addOption() {
            const container = document.getElementById('options-container');

            const html = `
        <div class="option-row flex gap-4 items-start bg-slate-50 p-3 rounded-xl border border-slate-200 animate-fade-in">
            <div class="flex-grow">
                <input type="text" name="options[${optionIndex}][text]" class="w-full rounded-lg border-slate-300 text-sm" placeholder="Opsi Baru..." required>
            </div>
            <div class="w-24">
                <input type="number" name="options[${optionIndex}][score]" class="w-full rounded-lg border-slate-300 text-sm" placeholder="Nilai" required>
            </div>
            <div class="pt-1">
                <button type="button" onclick="removeOption(this)" class="text-red-500 hover:text-red-700 p-2"><i class="bi bi-trash-fill"></i></button>
            </div>
        </div>
        `;

            // Insert HTML baru ke container
            container.insertAdjacentHTML('beforeend', html);
            optionIndex++;
        }

        function removeOption(button) {
            // Hapus elemen parent (div.option-row)
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
