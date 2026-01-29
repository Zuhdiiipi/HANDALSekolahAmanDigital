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
        $rankings = Cache::remember('school_rankings', 3600, function () {
            return School::orderBy('current_score', 'desc')->get();
        });
        return view('pages.ranking', compact('rankings'));
    }

    public function storeRegistration(Request $request)
    {
        $validated = $request->validate([
            'school_name'    => 'required|string|max:255',
            'jenjang'        => 'required|in:SMA,SMK,MA',
            'province'       => 'required|string',
            'city'           => 'required|string',
            'district'       => 'required|string',
            'village'        => 'required|string',
            'address'        => 'required|string',
            'contact_number' => 'required|numeric',
            'email'          => 'required|email|unique:registrations,email',
            'npsn'           => 'required|numeric|unique:registrations,npsn',
            'assessment_letter' => 'required|file|mimes:pdf|max:2048',
        ], [
            'npsn.unique' => 'NPSN ini sudah terdaftar sebelumnya.',
            'email.unique' => 'Email ini sudah digunakan untuk pendaftaran.',
            'assessment_letter.max' => 'Ukuran file surat asesmen maksimal 2MB.',
            'assessment_letter.mimes' => 'Format file harus PDF.'
        ]);

        if ($request->hasFile('assessment_letter')) {
            $filePath = $request->file('assessment_letter')->store('registration_letters', 'public');
            $validated['assessment_letter'] = $filePath;
        }

        $validated['status'] =
            Registration::create($validated);

        return back()->with('success', 'Permohonan akun berhasil dikirim! Silakan tunggu verifikasi validator via email.');
    }
}
