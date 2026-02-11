<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SurveyController extends Controller
{
    public function start()
    {
        $user = Auth::user();
        if (!$user->school) return back()->with('error', 'Profil sekolah belum ada.');
        $existingSurvey = Survey::where('school_id', $user->school->id)
            ->where('year', date('Y'))
            ->first();

        if ($existingSurvey && $existingSurvey->status !== 'draft') {
            return redirect()->route('school.dashboard')
                ->with('error', 'Anda sudah menyelesaikan asesmen tahun ini.');
        }
        $survey = Survey::firstOrCreate(
            ['school_id' => $user->school->id, 'year' => date('Y')],
            ['status' => 'draft', 'total_score' => 0]
        );
        if ($survey->status === 'submitted') {
            return redirect()->route('school.dashboard');
        }

        return redirect()->route('school.survey.step', 1);
    }
    public function step($stepNumber)
    {
        $user = Auth::user();
        $survey = Survey::where('school_id', $user->school->id)
            ->where('year', date('Y'))
            ->first();
        if ($survey && $survey->status !== 'draft') {
            return redirect()->route('school.dashboard')
                ->with('error', 'Akses ditolak. Survei sedang dikunci.');
        }

        $categories = SurveyCategory::orderBy('id')->get();
        if ($stepNumber < 1 || $stepNumber > $categories->count()) {
            return redirect()->route('school.dashboard');
        }

        $currentCategory = $categories[$stepNumber - 1];
        $currentCategory->load('questions.options');
        $existingAnswers = SurveyAnswer::where('survey_id', $survey->id ?? 0)
            ->get()
            ->keyBy('question_id');

        return view('school.survey.wizard', [
            'currentStep' => $stepNumber,
            'totalSteps' => $categories->count(),
            'category' => $currentCategory,
            'questions' => $currentCategory->questions,
            'existingAnswers' => $existingAnswers
        ]);
    }
    public function process(Request $request, $stepNumber)
    {
        $user = Auth::user();
        $survey = Survey::where('school_id', $user->school->id)
            ->where('year', date('Y'))
            ->where('status', 'draft')
            ->first();
        if (!$survey) {
            return redirect()->route('school.dashboard')
                ->with('error', 'Sesi survei tidak ditemukan atau sudah dikunci.');
        }
        if ($request->has('answers')) {
            foreach ($request->answers as $questionId => $optionId) {
                $existingAnswer = SurveyAnswer::where('survey_id', $survey->id)
                    ->where('question_id', $questionId)
                    ->first();

                $noteToSave = $existingAnswer ? $existingAnswer->validator_note : null;
                if ($existingAnswer && $existingAnswer->answer_value != $optionId) {
                    $noteToSave = null;
                }
                SurveyAnswer::updateOrCreate(
                    [
                        'survey_id'   => $survey->id,
                        'question_id' => $questionId
                    ],
                    [
                        'answer_value'   => $optionId,
                        'validator_note' => $noteToSave
                    ]
                );
            }
        }
        $totalSteps = SurveyCategory::count();

        if ($stepNumber < $totalSteps) {
            return redirect()->route('school.survey.step', $stepNumber + 1);
        } else {
            $this->calculateFinalScore($survey);
            return redirect()->route('school.dashboard')
                ->with('success', 'Asesmen berhasil disubmit! Nilai sementara Anda sudah keluar.');
        }
    }
    private function calculateFinalScore(Survey $survey)
    {
        $totalObtainedScore = 0;
        $maxPossibleScore = 0;
        $categories = SurveyCategory::with('questions.options')->get();

        foreach ($categories as $category) {
            foreach ($category->questions as $question) {
                $maxQuestionScore = $question->options->max('score_value');
                if (!$maxQuestionScore) continue;

                $maxPossibleScore += $maxQuestionScore;
                $answer = SurveyAnswer::where('survey_id', $survey->id)
                    ->where('question_id', $question->id)
                    ->first();

                if ($answer) {
                    $selectedOption = $question->options->where('id', $answer->answer_value)->first();
                    if ($selectedOption) {
                        $totalObtainedScore += $selectedOption->score_value;
                    }
                }
            }
        }
        if ($maxPossibleScore > 0) {
            $finalScore = ($totalObtainedScore / $maxPossibleScore) * 100;
        } else {
            $finalScore = 0;
        }
        $survey->update([
            'total_score' => $finalScore,
            'status' => 'submitted'
        ]);

        $survey->school->update(['current_score' => $finalScore]);
        Cache::forget('school_rankings');
    }

    public function result($id)
    {
        $user = Auth::user();

        $survey = Survey::with(['answers.question.options'])
            ->firstOrFail();

        return view('school.survey.result', compact('survey'));
    }
}
