<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Survey; // Import Model Survey
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $school = $user->school;

        $currentSurvey = Survey::where('school_id', $school->id)
            ->where('year', date('Y'))
            ->first();

        $surveyStatus = $currentSurvey ? $currentSurvey->status : 'none';

        return view('school.dashboard', compact('user', 'school', 'currentSurvey', 'surveyStatus'));
    }
}
