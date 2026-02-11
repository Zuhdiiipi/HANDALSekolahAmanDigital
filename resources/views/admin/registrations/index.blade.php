@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Penerbitan Akun Sekolah</h2>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-blue-50 text-blue-800">
                    <tr>
                        <th class="px-6 py-4 font-bold">Nama Sekolah</th>
                        <th class="px-6 py-4 font-bold">NPSN</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($registrations as $reg)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700">{{ $reg->school_name }}</div>
                                <div class="text-xs text-slate-500">{{ $reg->jenjang }}</div>
                            </td>

                            <td class="px-6 py-4">{{ $reg->npsn }}</td>

                            <td class="px-6 py-4">
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">
                                    <i class="bi bi-check-circle-fill"></i> Terverifikasi
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right flex justify-end gap-2">

                                <form action="{{ route('admin.registrations.create', $reg->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-bold text-sm shadow-sm transition-all flex items-center">
                                        <i class="bi bi-key-fill mr-2"></i> Terbitkan
                                    </button>
                                </form>

                                <button
                                    data-id="{{ $reg->id }}"
                                    data-name="{{ $reg->school_name }}"
                                    onclick="openAdminRejectModal(this)"
                                    class="bg-orange-50 text-orange-600 hover:bg-orange-100 px-4 py-2 rounded-lg font-bold text-sm border border-orange-200 transition-all flex items-center">
                                    <i class="bi bi-arrow-counterclockwise mr-2"></i> Kembalikan
                                </button>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                Tidak ada data yang menunggu persetujuan admin.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="adminRejectModal"
        class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl">
            <h3 class="text-xl font-bold text-slate-900 mb-2">Kembalikan ke Validator?</h3>

            <p class="text-slate-500 text-sm mb-4">
                Berikan catatan untuk validator mengenai data
                <span id="modalSchoolName" class="font-bold"></span>
            </p>

            <form id="rejectForm" method="POST">
                @csrf

                <textarea
                    name="admin_note"
                    rows="3"
                    required
                    class="w-full border-slate-300 rounded-xl focus:ring-orange-500 focus:border-orange-500 mb-4 p-3 text-sm"
                    placeholder="Contoh: Nama sekolah typo, mohon cek ulang berkas PDF..."></textarea>

                <div class="flex gap-2">
                    <button
                        type="button"
                        onclick="closeAdminRejectModal()"
                        class="flex-grow py-2.5 text-slate-500 font-bold hover:bg-slate-50 rounded-lg">
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="flex-grow py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-bold shadow-md">
                        Kirim ke Validator
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAdminRejectModal(button) {
            const id = button.dataset.id;
            const name = button.dataset.name;

            document.getElementById('modalSchoolName').innerText = name;

            let url = "{{ route('admin.registrations.reject', ':id') }}";
            document.getElementById('rejectForm').action = url.replace(':id', id);

            document.getElementById('adminRejectModal').classList.remove('hidden');
        }

        function closeAdminRejectModal() {
            document.getElementById('adminRejectModal').classList.add('hidden');
        }
    </script>
@endsection
