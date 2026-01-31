@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Profil Sekolah</h1>
        <p class="text-slate-500">Kelola informasi sekolah dan keamanan akun.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl mb-6 border border-emerald-100 font-bold flex items-center">
            <i class="bi bi-check-circle-fill mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- KOLOM KIRI: UPDATE DATA SEKOLAH --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                    <i class="bi bi-building-fill text-blue-600 mr-2"></i> Informasi Sekolah
                </h2>

                <form action="{{ route('school.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        
                        {{-- NPSN (READ ONLY) --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-500 mb-2">
                                NPSN <span class="text-xs font-normal text-slate-400">(Terkunci)</span>
                            </label>
                            <div class="relative">
                                <input type="text" value="{{ $school->npsn }}" disabled
                                    class="w-full bg-slate-100 text-slate-500 rounded-xl border-slate-200 cursor-not-allowed pl-10">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <i class="bi bi-lock-fill"></i>
                                </div>
                            </div>
                        </div>

                        {{-- NAMA SEKOLAH (READ ONLY) --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-500 mb-2">
                                Nama Sekolah <span class="text-xs font-normal text-slate-400">(Terkunci)</span>
                            </label>
                            <div class="relative">
                                <input type="text" value="{{ $school->name }}" disabled
                                    class="w-full bg-slate-100 text-slate-500 rounded-xl border-slate-200 cursor-not-allowed pl-10">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <i class="bi bi-lock-fill"></i>
                                </div>
                            </div>
                            <p class="text-xs text-slate-400 mt-2">
                                <i class="bi bi-info-circle mr-1"></i> Hubungi Admin jika ingin mengubah NPSN atau Nama Sekolah.
                            </p>
                        </div>

                        <div class="border-t border-slate-100 my-4"></div>

                        {{-- JENJANG (EDITABLE) --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Jenjang Pendidikan</label>
                            <select name="jenjang" class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                                <option value="SMA" {{ $school->jenjang == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="SMK" {{ $school->jenjang == 'SMK' ? 'selected' : '' }}>SMK</option>
                                <option value="MA" {{ $school->jenjang == 'MA' ? 'selected' : '' }}>MA</option>
                            </select>
                            @error('jenjang') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- EMAIL (EDITABLE) --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Email Akun</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- NO TELEPON (EDITABLE) --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Telepon</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number', $school->phone_number ?? '') }}" 
                                class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="08...">
                            @error('phone_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- ALAMAT (EDITABLE) --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap</label>
                            <textarea name="address" rows="3" 
                                class="w-full rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500">{{ old('address', $school->address ?? '') }}</textarea>
                            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- KOLOM KANAN: GANTI PASSWORD --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8 sticky top-6">
                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                    <i class="bi bi-shield-lock-fill text-emerald-600 mr-2"></i> Keamanan
                </h2>

                <form action="{{ route('school.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Password Saat Ini</label>
                            <input type="password" name="current_password" required
                                class="w-full rounded-xl border-slate-300 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Password Baru</label>
                            <input type="password" name="password" required
                                class="w-full rounded-xl border-slate-300 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full rounded-xl border-slate-300 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full bg-white border border-slate-300 text-slate-700 font-bold py-3 px-4 rounded-xl hover:bg-slate-50 hover:text-emerald-700 hover:border-emerald-200 transition-all">
                            Ganti Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection