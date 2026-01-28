<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil sekolah.
     */
    public function index()
    {
        // Ambil data sekolah dari user yang login
        $school = Auth::user()->school;

        // Tampilkan view profil dengan data sekolah
        return view('school.profile', compact('school'));
    }

    /**
     * Memproses update password.
     */
    public function updatePassword(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus 8 karakter.',
        ]);

        // 2. Update Password User
        $user = Auth::user();

        // Hash password sebelum disimpan
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // 3. Kembali dengan pesan sukses
        return back()->with('success', 'Password berhasil diperbarui! Silakan ingat password baru Anda.');
    }
}
