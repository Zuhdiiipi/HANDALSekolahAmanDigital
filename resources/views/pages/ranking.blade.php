@extends('layouts.app')

@section('title', 'Ranking Sekolah')

@section('content')
<div class="max-w-5xl mx-auto">
    
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 text-sm">
            <li>
                <a href="/" class="text-slate-500 hover:text-blue-600 transition-colors font-medium">
                    Beranda
                </a>
            </li>
            <li aria-hidden="true" class="text-slate-400">/</li>
            <li class="font-semibold text-slate-800">Ranking Sekolah</li>
        </ol>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        
        <div class="p-6 md:p-8 border-b border-slate-50">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-emerald-600 mb-2">
                        Ranking Keamanan Digital
                    </h2>
                    <p class="text-slate-500 text-sm">
                        Data diperbarui secara <span class="font-semibold text-emerald-600">real-time</span> berdasarkan hasil survei terbaru.
                    </p>
                </div>
                <div class="hidden md:block p-3 bg-emerald-50 rounded-full text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0V5.625a2.25 2.25 0 10-4.5 0v1.5" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-600 text-xs uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Peringkat</th>
                        <th class="px-6 py-4 w-full">Nama Sekolah</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Skor Keamanan</th>
                    </tr>
                </thead>
                
                <tbody class="divide-y divide-slate-100">
                    @forelse($rankings as $index => $school)
                    <tr class="hover:bg-slate-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            @if($index == 0)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 text-yellow-700 font-bold shadow-sm">1</span>
                            @elseif($index == 1)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-700 font-bold shadow-sm">2</span>
                            @elseif($index == 2)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-800 font-bold shadow-sm">3</span>
                            @else
                                <span class="text-slate-400 font-semibold ps-2">#{{ $index + 1 }}</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 font-medium text-slate-700">
                            {{ $school->name }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                {{ number_format($school->current_score, 2) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-slate-400">
                            <p>Belum ada data ranking tersedia.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
    </div>
</div>
@endsection