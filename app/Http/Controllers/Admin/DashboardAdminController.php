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
        $stats = [
            'active_schools' => School::count(),
            'waiting_for_account' => Registration::where('status', 'verified')->count(),
            'pending_validator' => Registration::where('status', 'pending')->count(),
            'rejected' => Registration::where('status', 'rejected')->count(),
        ];

        $recentRegistrations = Registration::latest()->take(5)->get();
        $topSchools = School::orderBy('current_score', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentRegistrations', 'topSchools'));
    }
}
