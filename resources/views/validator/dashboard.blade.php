@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto">
        <header class="mb-8">
            <h2 class="text-3xl font-extrabold text-slate-900">Pendaftaran Pending</h2>
            <p class="text-slate-500">Berikut adalah daftar sekolah yang menunggu verifikasi akun.</p>
        </header>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Nama Sekolah</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Jenjang</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">NPSN</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-center">Tgl Daftar</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($registrations as $reg)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $reg->school_name }}</td>
                            <td class="px-6 py-4 text-slate-600"><span
                                    class="px-2 py-1 bg-slate-100 rounded text-xs">{{ $reg->jenjang }}</span></td>
                            <td class="px-6 py-4 font-mono text-slate-500">{{ $reg->npsn }}</td>
                            <td class="px-6 py-4 text-center text-slate-500 text-sm">{{ $reg->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('validator.show', $reg->id) }}"
                                    class="text-blue-600 hover:text-blue-800 font-bold text-sm">Detail <i
                                        class="bi bi-arrow-right"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
