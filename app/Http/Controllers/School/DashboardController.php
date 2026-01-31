<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $school = $user->school;

        // 1. Ambil Survei Tahun Ini (Untuk Banner Utama)
        $currentSurvey = Survey::where('school_id', $school->id)
            ->where('year', date('Y'))
            ->first();

        // 2. Ambil SEMUA Riwayat Survei (Untuk Tabel Riwayat)
        // Diurutkan berdasarkan tahun terbaru (descending)
        $historySurveys = Survey::where('school_id', $school->id)
            ->orderBy('year', 'desc')
            ->get();

        $surveyStatus = $currentSurvey ? $currentSurvey->status : 'none';

        // Jangan lupa kirim 'historySurveys' ke view
        return view('school.dashboard', compact('user', 'school', 'currentSurvey', 'surveyStatus', 'historySurveys'));
    }
}
