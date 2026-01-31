@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.categories.index') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-500 hover:bg-slate-50 hover:text-blue-600 transition-colors">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-800">Tambah Kategori Baru</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                {{-- Nama Kategori --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kategori / Bab</label>
                    <input type="text" name="name" class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500 placeholder:text-slate-400" placeholder="Contoh: Infrastruktur Digital" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tombol --}}
                <div class="pt-4 flex justify-end gap-3">
                    <button type="reset" class="px-6 py-3 font-bold text-slate-500 hover:bg-slate-50 rounded-xl transition-colors">Reset</button>
                    <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg transition-all">
                        Simpan Kategori
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection