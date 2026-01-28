@extends('layouts.app')

@section('title', 'Formulir Pendaftaran Sekolah')

@section('content')
    <div class="max-w-4xl mx-auto">

        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 text-sm">
                <li>
                    <a href="/" class="text-slate-500 hover:text-blue-600 transition-colors font-medium">
                        Beranda
                    </a>
                </li>
                <li aria-hidden="true" class="text-slate-400">/</li>
                <li class="font-semibold text-slate-800">Pendaftaran Sekolah</li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">

            <div class="bg-blue-600 px-6 py-8 text-center">
                <h3 class="text-2xl font-bold text-white mb-2">Formulir Pendaftaran Sekolah</h3>
                <p class="text-blue-100 text-sm">Lengkapi data di bawah ini untuk pengajuan akun sistem</p>
            </div>

            <div class="p-6 md:p-10">
                {{-- Alert Sukses --}}
                @if (session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center shadow-sm"
                        role="alert">
                        <i class="bi bi-check-circle-fill text-xl mr-3"></i>
                        <div>
                            <span class="font-bold">Berhasil!</span>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                {{-- Alert Error Validasi (Jika ada input salah) --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-sm"
                        role="alert">
                        <div class="flex items-center mb-1">
                            <i class="bi bi-exclamation-triangle-fill text-xl mr-3"></i>
                            <span class="font-bold">Terjadi Kesalahan!</span>
                        </div>
                        <ul class="list-disc list-inside text-sm ml-8">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-10 border-b border-slate-100 pb-10 last:border-0 last:pb-0">
                        <h5 class="text-lg font-bold text-blue-600 mb-6 flex items-center">
                            <i class="bi bi-info-circle-fill mr-2"></i> Identitas Utama Sekolah
                        </h5>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            <div class="md:col-span-6">
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Nama Sekolah</label>
                                <input type="text" name="school_name"
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-slate-400"
                                    placeholder="Contoh: SMA Negeri 1 Makassar " required>
                            </div>

                            <div class="md:col-span-3">
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Jenjang</label>
                                <select name="jenjang"
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all bg-white"
                                    required>
                                    <option value="">Pilih...</option>
                                    <option value="SMA">SMA</option>
                                    <option value="SMK">SMK</option>
                                    <option value="MA">MA</option>
                                </select>
                            </div>

                            <div class="md:col-span-3">
                                <label class="block mb-2 text-sm font-semibold text-slate-700">NPSN</label>
                                <input type="text" name="npsn"
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-slate-400"
                                    placeholder="Nomor Pokok" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-10 border-b border-slate-100 pb-10 last:border-0 last:pb-0">
                        <h5 class="text-lg font-bold text-blue-600 mb-6 flex items-center">
                            <i class="bi bi-geo-alt-fill mr-2"></i> Lokasi Sekolah
                        </h5>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Provinsi</label>
                                <select name="province"
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all bg-white"
                                    required>
                                    <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                                    <option value="Sulawesi Barat">Sulawesi Barat</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Kabupaten / Kota</label>
                                <input type="text" name="city"
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                    placeholder="Contoh: Makassar" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Kecamatan</label>
                                <input type="text" name="district"
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                    placeholder="Kecamatan..." required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            <div class="md:col-span-4">
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Kelurahan / Desa</label>
                                <input type="text" name="village"
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                    placeholder="Kelurahan..." required>
                            </div>
                            <div class="md:col-span-8">
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Alamat Lengkap</label>
                                <input type="text" name="address"
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                    placeholder="Jalan, Nomor, RT/RW..." required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-10">
                        <h5 class="text-lg font-bold text-blue-600 mb-6 flex items-center">
                            <i class="bi bi-envelope-fill mr-2"></i> Kontak & Dokumen
                        </h5>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Nomor Kontak</label>
                                <div class="flex">
                                    <span
                                        class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 text-slate-500">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input type="text" name="contact_number"
                                        class="rounded-none rounded-r-lg bg-white border border-slate-300 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full px-4 py-2.5 outline-none transition-all"
                                        placeholder="08xxxxxxxx" required>
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Email Resmi</label>
                                <div class="flex">
                                    <span
                                        class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 text-slate-500">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" name="email"
                                        class="rounded-none rounded-r-lg bg-white border border-slate-300 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full px-4 py-2.5 outline-none transition-all"
                                        placeholder="admin@sekolah.sch.id" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-semibold text-slate-700">Surat Asesmen (PDF)</label>
                            <div class="relative group">
                                <div id="upload-container"
                                    class="flex flex-col items-center justify-center w-full h-40 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-blue-50 hover:border-blue-400 transition-all duration-300">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 px-4 text-center">
                                        <i id="upload-icon"
                                            class="bi bi-cloud-arrow-up text-4xl text-slate-400 mb-2 group-hover:text-blue-500 transition-colors"></i>

                                        <p id="file-name" class="mb-1 text-sm text-slate-500 font-medium">
                                            Klik untuk upload atau seret file
                                        </p>

                                        <p id="file-help" class="text-xs text-slate-400">
                                            PDF (Maks. 2MB)
                                        </p>
                                    </div>

                                    <input id="assessment_letter" name="assessment_letter" type="file" accept=".pdf"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required
                                        onchange="updateFileName(this)" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-200 flex items-center justify-center gap-2">
                            <i class="bi bi-send-check-fill"></i> Kirim Pengajuan Sekarang
                        </button>
                        <p class="text-center text-slate-400 text-xs mt-3">
                            Data akan diverifikasi manual oleh validator sebelum akun diterbitkan.
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileNameElement = document.getElementById('file-name');
            const fileHelpElement = document.getElementById('file-help');
            const uploadIcon = document.getElementById('upload-icon');
            const container = document.getElementById('upload-container');

            if (input.files && input.files[0]) {
                // 1. Ambil nama file
                const file = input.files[0];

                // 2. Ubah teks menjadi nama file
                fileNameElement.innerText = file.name;
                fileNameElement.classList.add('text-blue-600', 'font-bold');

                // 3. Ubah teks bantuan
                // Konversi ukuran file ke KB/MB
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                fileHelpElement.innerText = `Ukuran: ${fileSize} MB (Klik lagi untuk mengganti)`;

                // 4. Ubah Ikon menjadi "Dokumen Checklist"
                uploadIcon.className = 'bi bi-file-earmark-check-fill text-4xl text-blue-600 mb-2';

                // 5. Ubah border container agar terlihat aktif
                container.classList.add('border-blue-500', 'bg-blue-50');
                container.classList.remove('border-slate-300', 'bg-slate-50');
            } else {
                // Jika user membatalkan upload (cancel), kembalikan ke tampilan awal
                fileNameElement.innerText = 'Klik untuk upload atau seret file';
                fileNameElement.classList.remove('text-blue-600', 'font-bold');
                fileHelpElement.innerText = 'PDF (Maks. 2MB)';
                uploadIcon.className =
                    'bi bi-cloud-arrow-up text-4xl text-slate-400 mb-2 group-hover:text-blue-500 transition-colors';
                container.classList.remove('border-blue-500', 'bg-blue-50');
                container.classList.add('border-slate-300', 'bg-slate-50');
            }
        }
    </script>
@endsection
