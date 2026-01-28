<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing');
    }

    public function registrationPage()
    {
        return view('pages.registration');
    }

    public function rankingPage()
    {
        // Cache ranking selama 1 jam agar loading cepat
        $rankings = Cache::remember('school_rankings', 3600, function () {
            return School::orderBy('current_score', 'desc')->get();
        });
        return view('pages.ranking', compact('rankings'));
    }

    public function storeRegistration(Request $request)
    {
        // 1. Validasi Input (Diperketat)
        $validated = $request->validate([
            'school_name'    => 'required|string|max:255',
            'jenjang'        => 'required|in:SMA,SMK,MA', // Pastikan hanya nilai ini
            'province'       => 'required|string',
            'city'           => 'required|string',
            'district'       => 'required|string',
            'village'        => 'required|string',
            'address'        => 'required|string',
            'contact_number' => 'required|numeric', // Pastikan angka
            'email'          => 'required|email|unique:registrations,email', // Cek duplikat
            'npsn'           => 'required|numeric|unique:registrations,npsn', // Cek duplikat NPSN
            'assessment_letter' => 'required|file|mimes:pdf|max:2048', // Wajib PDF, Max 2MB
        ], [
            // Custom Error Messages (Opsional, agar lebih ramah)
            'npsn.unique' => 'NPSN ini sudah terdaftar sebelumnya.',
            'email.unique' => 'Email ini sudah digunakan untuk pendaftaran.',
            'assessment_letter.max' => 'Ukuran file surat asesmen maksimal 2MB.',
            'assessment_letter.mimes' => 'Format file harus PDF.'
        ]);

        // 2. Handling Upload File
        if ($request->hasFile('assessment_letter')) {
            // Simpan di folder 'storage/app/public/registration_letters'
            $filePath = $request->file('assessment_letter')->store('registration_letters', 'public');
            $validated['assessment_letter'] = $filePath;
        }

        // 3. Set Default Status
        $validated['status'] = 'pending';

        // 4. Simpan ke Database
        Registration::create($validated);

        // 5. Redirect Kembali dengan Pesan Sukses
        return back()->with('success', 'Permohonan akun berhasil dikirim! Silakan tunggu verifikasi validator via email.');
    }
}
