@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- HEADER --}}
        <div
            class="relative bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 mb-10 shadow-xl overflow-hidden text-white">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div
                        class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-3xl font-bold border border-white/30 shadow-inner">
                        <i class="bi bi-buildings-fill"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black tracking-tight">Profil Sekolah</h1>
                        <p class="text-blue-100 mt-1 text-lg">Kelola identitas dan keamanan akun sekolah Anda.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ALERT --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="bg-emerald-50 text-emerald-700 p-4 rounded-xl mb-8 border border-emerald-100 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="bg-emerald-100 p-2 rounded-full text-emerald-600">
                        <i class="bi bi-check-lg text-xl"></i>
                    </div>
                    <div>
                        <span class="font-bold block">Berhasil!</span>
                        <span class="text-sm">{{ session('success') }}</span>
                    </div>
                </div>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-700">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- UPDATE DATA --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="bi bi-pencil-square text-blue-600"></i> Informasi Umum
                        </h2>
                    </div>

                    <div class="p-8">
                        <form action="{{ route('school.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">

                                <div
                                    class="bg-slate-50 p-5 rounded-2xl border border-slate-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">NPSN</label>
                                        <div
                                            class="flex items-center gap-3 text-slate-600 font-bold bg-white px-4 py-3 rounded-xl border border-slate-200 shadow-sm">
                                            <i class="bi bi-upc-scan text-slate-400"></i>
                                            {{ $school->npsn }}
                                            <i class="bi bi-lock-fill text-slate-300 ml-auto"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama
                                            Sekolah</label>
                                        <div
                                            class="flex items-center gap-3 text-slate-600 font-bold bg-white px-4 py-3 rounded-xl border border-slate-200 shadow-sm">
                                            <i class="bi bi-building text-slate-400"></i>
                                            {{ $school->name }}
                                            <i class="bi bi-lock-fill text-slate-300 ml-auto"></i>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Jenjang Pendidikan</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500">
                                            <i class="bi bi-mortarboard-fill"></i>
                                        </div>
                                        <select name="jenjang"
                                            class="w-full pl-11 pr-4 py-3 bg-white rounded-xl border border-slate-300 text-slate-700 font-medium 
                                               focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 hover:border-blue-400 transition-all duration-200 cursor-pointer">
                                            <option value="SMA" {{ $school->jenjang == 'SMA' ? 'selected' : '' }}>Sekolah
                                                Menengah Atas (SMA)</option>
                                            <option value="SMK" {{ $school->jenjang == 'SMK' ? 'selected' : '' }}>Sekolah
                                                Menengah Kejuruan (SMK)</option>
                                            <option value="MA" {{ $school->jenjang == 'MA' ? 'selected' : '' }}>Madrasah
                                                Aliyah (MA)</option>
                                        </select>
                                    </div>
                                    @error('jenjang')
                                        <p class="text-red-500 text-xs mt-1 pl-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Email Akun</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500">
                                                <i class="bi bi-envelope-fill"></i>
                                            </div>
                                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                                class="w-full pl-11 pr-4 py-3 bg-white rounded-xl border border-slate-300 text-slate-700 placeholder-slate-400 font-medium
                                                   focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 hover:border-blue-400 transition-all duration-200">
                                        </div>
                                        @error('email')
                                            <p class="text-red-500 text-xs mt-1 pl-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Telepon</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500">
                                                <i class="bi bi-telephone-fill"></i>
                                            </div>
                                            <input type="text" name="phone_number"
                                                value="{{ old('phone_number', $school->phone_number ?? '') }}"
                                                class="w-full pl-11 pr-4 py-3 bg-white rounded-xl border border-slate-300 text-slate-700 placeholder-slate-400 font-medium
                                                   focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 hover:border-blue-400 transition-all duration-200"
                                                placeholder="Contoh: 0812...">
                                        </div>
                                        @error('phone_number')
                                            <p class="text-red-500 text-xs mt-1 pl-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap</label>
                                    <div class="relative">
                                        <div class="absolute top-3 left-4 text-slate-500">
                                            <i class="bi bi-geo-alt-fill"></i>
                                        </div>
                                        <textarea name="address" rows="3"
                                            class="w-full pl-11 pr-4 py-3 bg-white rounded-xl border border-slate-300 text-slate-700 placeholder-slate-400 font-medium leading-relaxed resize-none
                                               focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-600 hover:border-blue-400 transition-all duration-200">{{ old('address', $school->address ?? '') }}</textarea>
                                    </div>
                                    @error('address')
                                        <p class="text-red-500 text-xs mt-1 pl-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-blue-600/30 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                                    <i class="bi bi-save2-fill"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- GANTI PASSWORD --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 md:p-8 sticky top-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xl shadow-sm border border-emerald-200">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Keamanan</h2>
                            <p class="text-xs text-slate-500">Perbarui kata sandi akun.</p>
                        </div>
                    </div>

                    <form action="{{ route('school.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-5">

                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">Password
                                    Saat Ini</label>
                                <div class="relative group">
                                    <input type="password" name="current_password" id="current_password" required
                                        class="w-full px-4 py-3 bg-white rounded-xl border border-slate-300 text-slate-700 font-medium
                                           focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-600 hover:border-emerald-400 transition-all duration-200">
                                    <button type="button" onclick="togglePassword('current_password')"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-emerald-600 transition-colors">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">Password
                                    Baru</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" required
                                        class="w-full px-4 py-3 bg-white rounded-xl border border-slate-300 text-slate-700 font-medium
                                           focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-600 hover:border-emerald-400 transition-all duration-200">
                                    <button type="button" onclick="togglePassword('password')"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-emerald-600 transition-colors">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">Ulangi
                                    Password Baru</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        required
                                        class="w-full px-4 py-3 bg-white rounded-xl border border-slate-300 text-slate-700 font-medium
                                           focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-600 hover:border-emerald-400 transition-all duration-200">
                                    <button type="button" onclick="togglePassword('password_confirmation')"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-emerald-600 transition-colors">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="submit"
                                class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all flex justify-center items-center gap-2 transform hover:-translate-y-0.5">
                                <i class="bi bi-check-lg"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const icon = input.nextElementSibling.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
@endsection
