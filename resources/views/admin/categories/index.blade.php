@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- 1. HEADER SECTION --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Kategori Survei</h1>
                <p class="text-slate-500 font-medium text-sm mt-1">Kelola pengelompokan pertanyaan asesmen.</p>
            </div>
            <a href="{{ route('admin.categories.create') }}"
                class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-indigo-200 hover:-translate-y-0.5 transition-all gap-2">
                <i class="bi bi-plus-lg text-lg"></i>
                <span>Buat Kategori</span>
            </a>
        </div>

        {{-- 2. FLASH MESSAGE --}}
        @if (session('success'))
            <div
                class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-4 rounded-2xl mb-8 shadow-sm flex items-center gap-3 animate-fade-in-down">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-check-lg text-xl"></i>
                </div>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- 3. TABEL DATA (Gradient Header) --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white">
                            <th class="pl-8 pr-4 py-5 text-xs font-bold uppercase tracking-widest text-white/90">Nama
                                Kategori</th>
                            <th
                                class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-center w-48 text-white/90">
                                Jumlah Soal</th>
                            <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-right w-40 text-white/90">
                                Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse($categories as $category)
                            <tr class="group hover:bg-indigo-50/30 transition-colors duration-200">
                                <td class="pl-8 pr-4 py-5 align-middle">
                                    <div class="flex flex-col justify-center h-full">
                                        <span
                                            class="font-bold text-slate-800 text-base block mb-1 group-hover:text-indigo-600 transition-colors">
                                            {{ $category->name }}
                                        </span>
                                        <span class="text-xs text-slate-400 font-medium">
                                            Updated: {{ $category->updated_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center align-middle">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 group-hover:bg-white group-hover:shadow-sm border border-transparent group-hover:border-slate-200 transition-all">
                                        <i class="bi bi-collection-fill text-slate-400"></i>
                                        {{ $category->questions_count }} Pertanyaan
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right align-middle">
                                    <div
                                        class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                                            class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all"
                                            title="Edit Data">
                                            <i class="bi bi-pencil-square text-lg"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Data soal di dalamnya juga akan terhapus.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all"
                                                title="Hapus Data">
                                                <i class="bi bi-trash-fill text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                                            <i class="bi bi-folder-x text-4xl text-slate-300"></i>
                                        </div>
                                        <h3 class="text-slate-900 font-bold text-lg mb-1">Belum ada kategori</h3>
                                        <p class="text-slate-500 text-sm max-w-xs mx-auto mb-6">
                                            Silakan tambahkan kategori baru untuk mulai membuat bank soal.
                                        </p>
                                        <a href="{{ route('admin.categories.create') }}"
                                            class="text-indigo-600 font-bold text-sm hover:underline">
                                            + Tambah Kategori Sekarang
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($categories->count() > 0)
                <div class="bg-slate-50 px-8 py-4 border-t border-slate-100 flex justify-between items-center">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                        Total Data: <span class="text-slate-800">{{ $categories->count() }}</span>
                    </p>
                </div>
            @endif
        </div>

    </div>
@endsection
