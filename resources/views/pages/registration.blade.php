@extends('layouts.app')

@section('title', 'Pendaftaran Sekolah Baru')

@section('content')
{{-- WRAPPER UTAMA: Background Effects --}}
<div class="min-h-screen relative overflow-hidden bg-slate-50">

    {{-- ===================================================================== --}}
    {{-- DEKORASI BACKGROUND (Sesuai Warna Logo: Biru, Merah, Kuning)          --}}
    {{-- ===================================================================== --}}
    
    {{-- 1. Pola Grid Halus (Dot Pattern) --}}
    <div class="absolute inset-0 pointer-events-none opacity-[0.4]" 
         style="background-image: radial-gradient(#94a3b8 1px, transparent 1px); background-size: 32px 32px;">
    </div>

    {{-- 2. Orb Biru (Dominan - Kanan Atas) --}}
    <div class="absolute -top-24 -right-24 w-[600px] h-[600px] bg-blue-500/20 rounded-full blur-[100px] animate-pulse"></div>
    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-cyan-400/20 rounded-full blur-[80px]"></div>

    {{-- 3. Orb Merah (Aksen - Kiri Bawah) --}}
    <div class="absolute -bottom-32 -left-20 w-[500px] h-[500px] bg-red-600/10 rounded-full blur-[120px]"></div>

    {{-- 4. Orb Kuning (Highlight - Kiri Tengah) --}}
    <div class="absolute top-1/3 -left-24 w-[300px] h-[300px] bg-yellow-500/20 rounded-full blur-[90px]"></div>


    {{-- ===================================================================== --}}
    {{-- KONTEN UTAMA (Formulir Asli Anda - Tidak Diubah Strukturnya)          --}}
    {{-- ===================================================================== --}}
    <div class="relative z-10 max-w-5xl mx-auto px-4 py-10">

        {{-- BREADCRUMB --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2 text-sm text-slate-500 bg-white/50 backdrop-blur-sm py-2 px-4 rounded-full border border-white/60 shadow-sm">
                <li><a href="/" class="hover:text-blue-600 transition-colors font-medium"><i class="bi bi-house-door-fill mr-1"></i> Beranda</a></li>
                <li class="text-slate-300">/</li>
                <li class="font-semibold text-blue-600" aria-current="page">Pendaftaran Sekolah</li>
            </ol>
        </nav>

        {{-- MAIN CARD CONTAINER --}}
        <div class="relative">
            {{-- Bayangan di belakang kartu --}}
            <div class="absolute inset-0 bg-blue-900/5 blur-2xl transform translate-y-4 rounded-[2.5rem]"></div>
            
            <div class="relative bg-white/90 backdrop-blur-xl rounded-[2rem] shadow-2xl border border-white/50 overflow-hidden">

                {{-- HEADER CARD --}}
                <div class="bg-gradient-to-r from-blue-700 via-blue-600 to-cyan-600 px-8 py-10 relative overflow-hidden text-white text-center md:text-left">
                    {{-- Dekorasi Abstrak Header --}}
                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-0 right-20 w-24 h-24 bg-yellow-400 opacity-20 rounded-full blur-2xl"></div>

                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight mb-2">Formulir Pendaftaran</h1>
                            <p class="text-blue-50 text-sm md:text-base opacity-90 font-light">Bergabunglah dengan ekosistem pendidikan digital masa depan.</p>
                        </div>
                        <div class="hidden md:block">
                            <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-inner">
                                <i class="bi bi-building-add text-3xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 md:p-12">
                    
                    {{-- ALERTS --}}
                    @if (session('success'))
                        <div class="mb-8 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl flex items-start gap-3 shadow-sm">
                            <i class="bi bi-check-circle-fill text-emerald-600 text-xl mt-0.5"></i>
                            <div>
                                <h3 class="text-emerald-800 font-bold text-sm">Pendaftaran Berhasil</h3>
                                <p class="text-emerald-700 text-sm mt-1">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-8 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl flex items-start gap-3 shadow-sm">
                            <i class="bi bi-exclamation-triangle-fill text-rose-600 text-xl mt-0.5"></i>
                            <div>
                                <h3 class="text-rose-800 font-bold text-sm">Perhatian</h3>
                                <ul class="list-disc list-inside text-rose-700 text-sm mt-1 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
                        @csrf

                        {{-- BAGIAN 1: IDENTITAS SEKOLAH --}}
                        <div class="relative pl-0 md:pl-10 border-l-0 md:border-l-2 border-slate-100">
                            {{-- Penanda Nomor --}}
                            <div class="hidden md:flex absolute -left-[17px] top-0 w-8 h-8 rounded-full bg-blue-600 text-white font-bold items-center justify-center shadow-lg shadow-blue-200">1</div>
                            
                            <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <span class="md:hidden bg-blue-100 text-blue-600 text-xs font-bold px-2 py-1 rounded">1</span>
                                Identitas Sekolah
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Nama Sekolah --}}
                                <div class="md:col-span-2">
                                    <label class="block mb-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Sekolah <span class="text-rose-500">*</span></label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="bi bi-mortarboard text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                        </div>
                                        <input type="text" name="school_name" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none font-medium text-slate-700 placeholder-slate-400" placeholder="Contoh: SMA Negeri 1 Makassar" required>
                                    </div>
                                </div>

                                {{-- Jenjang --}}
                                <div>
                                    <label class="block mb-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Jenjang <span class="text-rose-500">*</span></label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="bi bi-layers text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                        </div>
                                        <select name="jenjang" class="w-full pl-11 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none appearance-none cursor-pointer font-medium text-slate-700" required>
                                            <option value="" disabled selected>Pilih Jenjang</option>
                                            <option value="SMA">SMA</option>
                                            <option value="SMK">SMK</option>
                                            <option value="MA">MA</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <i class="bi bi-chevron-down text-xs text-slate-400"></i>
                                        </div>
                                    </div>
                                </div>

                                {{-- NPSN --}}
                                <div>
                                    <label class="block mb-2 text-xs font-bold text-slate-500 uppercase tracking-wider">NPSN <span class="text-rose-500">*</span></label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="bi bi-123 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                        </div>
                                        <input type="text" name="npsn" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none font-medium text-slate-700 placeholder-slate-400" placeholder="8 Digit Angka" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BAGIAN 2: LOKASI --}}
                        <div class="relative pl-0 md:pl-10 border-l-0 md:border-l-2 border-slate-100">
                            <div class="hidden md:flex absolute -left-[17px] top-0 w-8 h-8 rounded-full bg-white border-2 border-blue-600 text-blue-600 font-bold items-center justify-center">2</div>

                            <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <span class="md:hidden bg-blue-100 text-blue-600 text-xs font-bold px-2 py-1 rounded">2</span>
                                Lokasi & Alamat
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                {{-- Provinsi --}}
                                <div>
                                    <label class="block mb-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Provinsi</label>
                                    <div class="relative">
                                        <select name="province" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none appearance-none cursor-pointer" required>
                                            <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                                            <option value="Sulawesi Barat">Sulawesi Barat</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <i class="bi bi-chevron-down text-xs text-slate-400"></i>
                                        </div>
                                    </div>
                                </div>
                                {{-- Kota --}}
                                <div>
                                    <label class="block mb-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Kabupaten/Kota</label>
                                    <input type="text" name="city" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none" placeholder="Nama Kota" required>
                                </div>
                                {{-- Kecamatan --}}
                                <div>
                                    <label class="block mb-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Kecamatan</label>
                                    <input type="text" name="district" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none" placeholder="Nama Kecamatan" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                                <div class="md:col-span-4">
                                    <label class="block mb-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Kelurahan</label>
                                    <input type="text" name="village" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none" placeholder="Nama Kelurahan" required>
                                </div>
                                <div class="md:col-span-8">
                                    <label class="block mb-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Alamat Lengkap</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="bi bi-geo-alt text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                        </div>
                                        <input type="text" name="address" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none" placeholder="Jalan, Nomor, RT/RW" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BAGIAN 3: KONTAK --}}
                        <div class="relative pl-0 md:pl-10 border-l-0 md:border-l-2 border-slate-100">
                            <div class="hidden md:flex absolute -left-[17px] top-0 w-8 h-8 rounded-full bg-white border-2 border-blue-600 text-blue-600 font-bold items-center justify-center">3</div>

                            <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <span class="md:hidden bg-blue-100 text-blue-600 text-xs font-bold px-2 py-1 rounded">3</span>
                                Kontak & Dokumen
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                {{-- Kontak WA --}}
                                <div>
                                    <label class="block mb-2 text-xs font-bold text-slate-500 uppercase tracking-wider">WhatsApp Admin <span class="text-rose-500">*</span></label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="bi bi-whatsapp text-slate-400 group-focus-within:text-green-500 transition-colors"></i>
                                        </div>
                                        <input type="text" name="contact_number" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all" placeholder="08xxxxxxxx" required>
                                    </div>
                                </div>
                                {{-- Email --}}
                                <div>
                                    <label class="block mb-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Email Sekolah <span class="text-rose-500">*</span></label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="bi bi-envelope text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                        </div>
                                        <input type="email" name="email" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all" placeholder="admin@sekolah.sch.id" required>
                                    </div>
                                </div>
                            </div>

                            {{-- UPLOAD AREA --}}
                            <div>
                                <label class="block mb-3 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Upload Surat Permohonan <span class="ml-2 normal-case font-normal text-slate-400 bg-slate-100 px-2 py-0.5 rounded text-[10px]">Format PDF (Maks. 2MB)</span>
                                </label>
                                
                                <div class="relative group">
                                    <input id="assessment_letter" name="assessment_letter" type="file" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" required onchange="updateFileName(this)" />
                                    
                                    <div id="upload-container" class="flex flex-col items-center justify-center w-full h-36 border-2 border-slate-200 border-dashed rounded-2xl bg-slate-50 group-hover:bg-blue-50 group-hover:border-blue-400 transition-all duration-300">
                                        <div class="flex flex-col items-center justify-center text-center p-4 transition-transform group-hover:scale-105">
                                            <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center mb-3">
                                                <i id="upload-icon" class="bi bi-cloud-arrow-up-fill text-2xl text-blue-500"></i>
                                            </div>
                                            <p id="file-name" class="text-sm font-bold text-slate-700 group-hover:text-blue-700 transition-colors">
                                                Klik untuk upload dokumen
                                            </p>
                                            <p id="file-help" class="text-xs text-slate-400 mt-1">atau seret file ke sini</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER BUTTON --}}
                        <div class="pt-8 mt-8 border-t border-slate-100">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-blue-500/30 hover:-translate-y-1 transition-all duration-200 flex items-center justify-center gap-3">
                                <span>Kirim Pengajuan Sekarang</span>
                                <i class="bi bi-arrow-right-circle-fill text-lg"></i>
                            </button>
                            <p class="text-center text-slate-400 text-xs mt-4 flex items-center justify-center gap-1">
                                <i class="bi bi-lock-fill"></i> Data Anda dilindungi dan diverifikasi secara manual.
                            </p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script Upload (Visual Feedback) --}}
<script>
    function updateFileName(input) {
        const fileNameElement = document.getElementById('file-name');
        const fileHelpElement = document.getElementById('file-help');
        const uploadIcon = document.getElementById('upload-icon');
        const container = document.getElementById('upload-container');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            // Update Text
            fileNameElement.innerText = file.name;
            fileNameElement.classList.add('text-blue-700');
            
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            fileHelpElement.innerText = `Ukuran: ${fileSize} MB - Siap diupload`;
            fileHelpElement.classList.add('text-green-600', 'font-semibold');
            
            // Update Icon & Container Style
            uploadIcon.className = 'bi bi-file-earmark-pdf-fill text-2xl text-red-500';
            uploadIcon.parentElement.classList.add('bg-red-50');
            
            container.classList.remove('bg-slate-50', 'border-slate-200');
            container.classList.add('bg-blue-50', 'border-blue-500', 'border-solid'); // Solid border saat file ada
        } else {
            // Reset State
            fileNameElement.innerText = 'Klik untuk upload dokumen';
            fileNameElement.classList.remove('text-blue-700');
            
            fileHelpElement.innerText = 'atau seret file ke sini';
            fileHelpElement.classList.remove('text-green-600', 'font-semibold');

            uploadIcon.className = 'bi bi-cloud-arrow-up-fill text-2xl text-blue-500';
            uploadIcon.parentElement.classList.remove('bg-red-50');
            
            container.classList.add('bg-slate-50', 'border-slate-200', 'border-dashed');
            container.classList.remove('bg-blue-50', 'border-blue-500', 'border-solid');
        }
    }
</script>
@endsection