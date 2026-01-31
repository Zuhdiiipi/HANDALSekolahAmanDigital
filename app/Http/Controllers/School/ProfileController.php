<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // 1. Tampilkan Halaman Profil
    public function edit()
    {
        $user = Auth::user();
        $school = $user->school; // Relasi User ke School

        return view('school.profile', compact('user', 'school'));
    }

    // 2. Update Data Sekolah (Info Umum)
    public function update(Request $request)
    {
        $user = Auth::user();
        $school = $user->school;

        $request->validate([
            // Validasi Email (Unik, tapi abaikan email user ini sendiri)
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'jenjang' => 'required|in:SD,SMP,SMA,SMK', // Sesuaikan dengan opsi Anda
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        // Update Email Login (Tabel Users)
        $user->update([
            'email' => $request->email
        ]);

        // Update Data Sekolah (Tabel Schools)
        // Kita tidak update NPSN & Name karena dikunci
        $school->update([
            'jenjang' => $request->jenjang,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        return back()->with('success', 'Profil sekolah berhasil diperbarui.');
    }

    // 3. Update Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed', 
        ]);

        // Cek apakah password lama benar
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        // Update Password
        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
