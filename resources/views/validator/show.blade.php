@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-8">

        {{-- HEADER --}}
        <div class="mb-8">
            <a href="{{ route('validator.dashboard') }}"
                class="inline-flex items-center text-sm text-slate-500 hover:text-blue-600 transition-colors mb-4 group">
                <i class="bi bi-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                Kembali ke Dashboard
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Verifikasi Pendaftaran</h1>
                    <p class="text-slate-500 text-sm mt-1">Tinjau kelengkapan data sekolah sebelum menyetujui.</p>
                </div>
                <div class="hidden md:block">
                    <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-bold border border-blue-100">
                        PENDING REVIEW
                    </span>
                </div>
            </div>
        </div>

        {{-- ALERT --}}
        @if ($registration->admin_notes)
            <div
                class="mb-8 bg-orange-50 border border-orange-100 rounded-xl p-5 flex gap-4 shadow-sm relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-orange-500"></div>
                <div class="flex-shrink-0 bg-orange-100 rounded-lg p-2 h-fit text-orange-600">
                    <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-orange-800">Dikembalikan oleh Admin</h3>
                    <p class="text-sm text-orange-700 mt-1 leading-relaxed">"{{ $registration->admin_notes }}"</p>
                    <p class="text-xs text-orange-600/80 mt-2 font-semibold uppercase tracking-wide">Harap periksa poin
                        revisi di atas.</p>
                </div>
            </div>
        @endif

        {{-- KONTEN UTAMA --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-slate-50/50 px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                            <i class="bi bi-building-fill"></i>
                        </div>
                        <h2 class="font-bold text-slate-800">Profil Sekolah</h2>
                    </div>

                    <div class="p-6 grid gap-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama
                                    Sekolah</label>
                                <p class="text-lg font-bold text-slate-800">{{ $registration->school_name }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">NPSN</label>
                                <div
                                    class="inline-flex items-center gap-2 bg-slate-100 px-3 py-1 rounded-md text-slate-700 font-mono font-medium text-sm">
                                    <i class="bi bi-hash text-slate-400"></i> {{ $registration->npsn }}
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat
                                Lengkap</label>
                            <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <i class="bi bi-geo-alt-fill text-slate-400 mt-0.5"></i>
                                <p class="text-slate-700 text-sm leading-relaxed">
                                    {{ $registration->address }}<br>
                                    <span class="text-slate-500">
                                        Kel. {{ $registration->village }}, Kec. {{ $registration->district }},
                                        {{ $registration->city }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-slate-50/50 px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center">
                            <i class="bi bi-person-lines-fill"></i>
                        </div>
                        <h2 class="font-bold text-slate-800">Kontak Resmi</h2>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase">Email</label>
                                <p class="font-medium text-slate-800">{{ $registration->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400">
                                <i class="bi bi-whatsapp"></i>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase">WhatsApp</label>
                                <p class="font-medium text-slate-800">{{ $registration->contact_number }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- DOKUMEN & AKSI  --}}
            <div class="space-y-6">

                {{-- Card Dokumen (File Preview Look) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                    <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                        <i class="bi bi-paperclip text-slate-400"></i> Dokumen Pendukung
                    </h3>

                    <div
                        class="group relative block p-4 bg-slate-50 border border-slate-200 rounded-xl hover:border-blue-400 hover:bg-blue-50 transition-all cursor-pointer">
                        <a href="{{ asset('storage/' . $registration->assessment_letter) }}" target="_blank"
                            class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-red-100 text-red-500 rounded-lg flex items-center justify-center text-2xl shadow-sm group-hover:scale-110 transition-transform">
                                <i class="bi bi-file-earmark-pdf-fill"></i>
                            </div>
                            <div class="overflow-hidden">
                                <p
                                    class="text-sm font-bold text-slate-700 truncate group-hover:text-blue-700 transition-colors">
                                    Surat Permohonan.pdf</p>
                                <p class="text-xs text-slate-400 mt-0.5">Klik untuk melihat file</p>
                            </div>
                        </a>
                    </div>
                    <p class="text-xs text-slate-400 mt-3 text-center">Pastikan dokumen valid dan dapat dibaca.</p>
                </div>

                {{-- Card Aksi (Sticky/Highlighted) --}}
                <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6 sticky top-6">
                    <h3 class="font-bold text-slate-800 mb-1">Tindakan Validator</h3>
                    <p class="text-xs text-slate-500 mb-6">Putuskan status pendaftaran ini.</p>

                    <div class="space-y-3">
                        <form action="{{ route('validator.approve', $registration->id) }}" method="POST">
                            @csrf
                            <button
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3.5 px-4 rounded-xl font-bold shadow-blue-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                                <i class="bi bi-check-lg text-lg"></i>
                                Verifikasi & Setujui
                            </button>
                        </form>

                        <button onclick="openRejectModal()"
                            class="w-full bg-white border-2 border-red-100 text-red-600 hover:bg-red-50 hover:border-red-200 py-3.5 px-4 rounded-xl font-bold transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-x-lg"></i>
                            Tolak Pendaftaran
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="rejectModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:w-full sm:max-w-lg border border-slate-100">

                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="bi bi-exclamation-triangle text-red-600 text-lg"></i>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg font-bold leading-6 text-slate-900" id="modal-title">Tolak Pendaftaran</h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-500 mb-4">
                                    Pendaftaran akan dikembalikan ke sekolah untuk diperbaiki. Jelaskan alasannya di bawah
                                    ini.
                                </p>
                                <form action="{{ route('validator.reject', $registration->id) }}" method="POST"
                                    id="rejectForm">
                                    @csrf
                                    <textarea name="reason" rows="4"
                                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm p-3 bg-slate-50"
                                        placeholder="Contoh: Dokumen PDF buram, Nama sekolah tidak sesuai NPSN, dll..." required></textarea>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                    <button type="button" onclick="document.getElementById('rejectForm').submit();"
                        class="inline-flex w-full justify-center rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto transition-colors">
                        Kirim Penolakan
                    </button>
                    <button type="button" onclick="closeRejectModal()"
                        class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
@endsection
