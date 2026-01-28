@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('validator.dashboard') }}" class="text-slate-500 hover:text-slate-800 transition-colors">
                <i class="bi bi-chevron-left"></i> Kembali ke Dashboard
            </a>
            <a href="{{ asset('storage/' . $registration->assessment_letter) }}" target="_blank"
                class="bg-emerald-50 text-emerald-600 px-4 py-2 rounded-lg font-bold text-sm border border-emerald-100 hover:bg-emerald-100 transition-colors">
                <i class="bi bi-file-pdf"></i> Lihat Surat Asesmen
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <section>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Profil Sekolah</h4>
                    <div class="space-y-4">
                        <div><label class="block text-sm text-slate-400">Nama Sekolah</label>
                            <p class="font-bold text-slate-800">{{ $registration->school_name }}</p>
                        </div>
                        <div><label class="block text-sm text-slate-400">NPSN</label>
                            <p class="font-bold text-slate-800">{{ $registration->npsn }}</p>
                        </div>
                        <div><label class="block text-sm text-slate-400">Lokasi</label>
                            <p class="text-slate-700 leading-relaxed">{{ $registration->address }},
                                {{ $registration->village }}, {{ $registration->district }}, {{ $registration->city }}</p>
                        </div>
                    </div>
                </section>
                <section>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Kontak Resmi</h4>
                    <div class="space-y-4">
                        <div><label class="block text-sm text-slate-400">Email</label>
                            <p class="font-bold text-blue-600">{{ $registration->email }}</p>
                        </div>
                        <div><label class="block text-sm text-slate-400">Nomor Telepon</label>
                            <p class="font-bold text-slate-800">{{ $registration->contact_number }}</p>
                        </div>
                    </div>
                </section>
            </div>

            <hr class="border-slate-100">

            <div class="flex gap-4">
                <form action="{{ route('validator.approve', $registration->id) }}" method="POST" class="flex-grow">
                    @csrf
                    <button
                        class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition-all">Setujui
                        & Buat Akun</button>
                </form>
                <button onclick="openRejectModal()"
                    class="px-6 bg-red-50 text-red-600 py-3 rounded-xl font-bold hover:bg-red-100 transition-all">Tolak</button>
            </div>
        </div>
    </div>

    <div id="rejectModal"
        class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl">
            <h3 class="text-xl font-bold text-slate-900 mb-2">Alasan Penolakan</h3>
            <p class="text-slate-500 text-sm mb-4">Berikan alasan mengapa pendaftaran ini ditolak agar sekolah dapat
                memperbaiki data.</p>
            <form action="{{ route('validator.reject', $registration->id) }}" method="POST">
                @csrf
                <textarea name="reason" rows="4"
                    class="w-full border-slate-200 rounded-xl focus:ring-red-500 focus:border-red-500 mb-4 p-3"
                    placeholder="Contoh: File PDF surat asesmen tidak terbaca atau rusak." required></textarea>
                <div class="flex gap-2">
                    <button type="button" onclick="closeRejectModal()"
                        class="flex-grow py-2 text-slate-500 font-bold">Batal</button>
                    <button type="submit" class="flex-grow py-2 bg-red-600 text-white rounded-lg font-bold">Kirim
                        Penolakan</button>
                </div>
            </form>
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
