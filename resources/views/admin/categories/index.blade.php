@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kategori Survei</h1>
            {{-- Hapus kata 'Bobot' agar tidak bingung --}}
            <p class="text-slate-500">Kelola Bab / Kelompok Pertanyaan</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg transition-all flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl mb-6 border border-emerald-100 font-bold">
            <i class="bi bi-check-circle-fill mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 font-bold text-slate-600">Nama Kategori</th>
                    {{-- HAPUS KOLOM BOBOT DI SINI --}}
                    <th class="px-6 py-4 font-bold text-slate-600 text-center">Jumlah Soal</th>
                    <th class="px-6 py-4 font-bold text-slate-600 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($categories as $category)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $category->name }}</td>
                        
                        {{-- HAPUS KOLOM ISIAN BOBOT DI SINI --}}

                        <td class="px-6 py-4 text-center text-slate-500">
                            {{ $category->questions_count }} Pertanyaan
                        </td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-slate-400 hover:text-blue-600 p-2">
                                <i class="bi bi-pencil-square text-lg"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Semua soal di dalamnya akan ikut terhapus!');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-red-600 p-2">
                                    <i class="bi bi-trash-fill text-lg"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-slate-400">
                            <i class="bi bi-inbox text-4xl mb-3 block opacity-50"></i>
                            Belum ada kategori survei.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection