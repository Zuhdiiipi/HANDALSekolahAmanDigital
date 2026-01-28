<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data User yang sedang login
        $user = Auth::user();

        // Ambil data profil sekolah dari relasi (asumsi di model User ada relasi 'school')
        $school = $user->school;

        // Cek apakah sudah pernah ada riwayat survei/skor
        // (Mengambil skor dari kolom current_score di tabel schools)
        $lastScore = $school->current_score ?? null;

        // Kirim data ke View
        return view('school.dashboard', compact('user', 'school', 'lastScore'));
    }
}
