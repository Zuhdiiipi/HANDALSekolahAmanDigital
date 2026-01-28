<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // 1. Ambil Statistik untuk Card Atas
        $stats = [
            // Jumlah sekolah yang akunnya SUDAH aktif
            'active_schools' => School::count(),

            // Tugas Admin: Menunggu diterbitkan akun (Status Verified)
            'waiting_for_account' => Registration::where('status', 'verified')->count(),

            // Monitoring: Menunggu verifikasi Validator (Status Pending)
            'pending_validator' => Registration::where('status', 'pending')->count(),

            // Total pendaftaran yang ditolak
            'rejected' => Registration::where('status', 'rejected')->count(),
        ];

        // 2. Ambil 5 Pendaftaran Terbaru (Untuk tabel ringkasan)
        $recentRegistrations = Registration::latest()->take(5)->get();

        // 3. Ambil 5 Sekolah dengan Skor Tertinggi (Leaderboard Mini)
        $topSchools = School::orderBy('current_score', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentRegistrations', 'topSchools'));
    }
}
