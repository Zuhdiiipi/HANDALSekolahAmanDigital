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
        $currentSurvey = Survey::where('school_id', $school->id)
            ->where('year', date('Y'))
            ->first();
        $historySurveys = Survey::where('school_id', $school->id)
            ->orderBy('year', 'desc')
            ->get();

        $surveyStatus = $currentSurvey ? $currentSurvey->status : 'none';
        return view('school.dashboard', compact('user', 'school', 'currentSurvey', 'surveyStatus', 'historySurveys'));
    }
}
