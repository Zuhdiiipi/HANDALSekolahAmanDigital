<?php

namespace App\Http\Controllers\Validator;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountApproved;

class ValidatorController extends Controller
{
    // 1. Menampilkan Dashboard (Daftar Pending)
    public function index()
    {
        $registrations = Registration::where('status', 'pending')->latest()->get();
        return view('validator.dashboard', compact('registrations'));
    }

    // 2. Menampilkan Detail Sekolah (Route validator.show)
    public function show($id)
    {
        $registration = Registration::findOrFail($id);
        return view('validator.show', compact('registration'));
    }

    // 3. Logika Menyetujui Akun
    public function approve($id)
    {
        $reg = Registration::findOrFail($id);

        if ($reg->status !== 'pending') {
            return back()->with('error', 'Permohonan ini sudah diproses.');
        }

        $password = Str::random(10);

        $user = User::create([
            'name' => $reg->school_name,
            'email' => $reg->email,
            'password' => Hash::make($password),
            'role' => 'school',
        ]);

        School::create([
            'user_id' => $user->id,
            'name' => $reg->school_name,
            'address' => $reg->address,
            'jenjang' => $reg->jenjang, // Pastikan kolom ini ada di tabel schools
            'npsn' => $reg->npsn,       // Pastikan kolom ini ada di tabel schools
        ]);

        $reg->update(['status' => 'approved']);

        // --- KODE BARU: KIRIM EMAIL ---
        // Kita kirim email ke alamat sekolah dengan data User & Password mentah
        try {
            Mail::to($user->email)->send(new AccountApproved($user, $password));
        } catch (\Exception $e) {
            // Jika email gagal, jangan crash, tapi beri peringatan
            return redirect()->route('validator.dashboard')
                ->with('warning', 'Akun dibuat tapi Email gagal terkirim. Password: ' . $password);
        }
        // ------------------------------

        return redirect()->route('validator.dashboard')->with('success', 'Akun berhasil dibuat dan email telah dikirim!');
    }

    // 4. Logika Menolak Akun
    public function reject(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string']);

        $reg = Registration::findOrFail($id);
        $reg->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason // Pastikan kolom ini ada di database
        ]);

        return redirect()->route('validator.dashboard')->with('success', 'Permohonan telah ditolak.');
    }

    
}
