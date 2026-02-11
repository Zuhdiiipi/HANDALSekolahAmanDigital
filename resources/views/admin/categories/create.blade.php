@extends('layouts.admin')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- 1. HEADER SECTION --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.categories.index') }}" 
               class="group w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:bg-slate-50 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm">
                <i class="bi bi-arrow-left text-lg group-hover:-translate-x-0.5 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Tambah Kategori</h1>
                <p class="text-slate-500 text-sm font-medium">Buat kelompok baru untuk pertanyaan survei.</p>
            </div>
        </div>

        {{-- 2. FORM CARD --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-8">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        
                        {{-- Input: Nama Kategori --}}
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
                                Nama Kategori / Bab
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="bi bi-tag-fill text-slate-400"></i>
                                </div>
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-800 text-sm font-bold rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-slate-400" 
                                       placeholder="Contoh: Infrastruktur Digital" 
                                       required>
                            </div>
                            @error('name')
                                <p class="mt-2 text-xs text-red-500 font-bold flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Divider --}}
                        <div class="border-t border-slate-100 pt-2"></div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-end gap-3">
                            <button type="reset" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:text-slate-700 hover:bg-slate-50 transition-all">
                                Reset
                            </button>
                            <button type="submit" 
                                    class="inline-flex items-center justify-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:-translate-y-0.5 transition-all gap-2">
                                <i class="bi bi-plus-lg text-lg"></i>
                                <span>Simpan Kategori</span>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection