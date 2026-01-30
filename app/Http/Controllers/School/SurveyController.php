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
    // 1. Memulai Sesi Survei Baru
    public function start()
    {
        $user = Auth::user();
        if (!$user->school) return back()->with('error', 'Profil sekolah belum ada.');

        // 1. CEK APAKAH SUDAH PERNAH SUBMIT TAHUN INI?
        $existingSurvey = Survey::where('school_id', $user->school->id)
            ->where('year', date('Y'))
            ->first();

        // if ($existingSurvey && $existingSurvey->status === 'submitted') {
        //     return redirect()->route('school.dashboard')
        //         ->with('error', 'Anda sudah menyelesaikan asesmen tahun ini. Hubungi Admin jika ingin revisi.');
        // }

        if ($existingSurvey && $existingSurvey->status !== 'draft') {
            return redirect()->route('school.dashboard')
                ->with('error', 'Anda sudah menyelesaikan asesmen tahun ini.');
        }

        // Jika belum atau masih draft, lanjutkan...
        $survey = Survey::firstOrCreate(
            ['school_id' => $user->school->id, 'year' => date('Y')], // Cari berdasarkan ini
            ['status' => 'draft', 'total_score' => 0] // Jika tidak ada, buat dengan data ini
        );

        // Pastikan statusnya draft (jaga-jaga)
        if ($survey->status === 'submitted') {
            return redirect()->route('school.dashboard');
        }

        return redirect()->route('school.survey.step', 1);
    }

    // 2. Menampilkan Pertanyaan Per Kategori (Step)
    public function step($stepNumber)
    {
        // 1. CEK SECURITY LAGI DI SINI
        // Agar user tidak bisa tembak URL /survey/step/2 padahal sudah submit
        $user = Auth::user();
        $survey = Survey::where('school_id', $user->school->id)
            ->where('year', date('Y'))
            ->first();

        // if ($survey && $survey->status === 'submitted') {
        //     return redirect()->route('school.dashboard')->with('error', 'Akses ditolak. Survei sudah dikunci.');
        // }

        if ($survey && $survey->status !== 'draft') {
            return redirect()->route('school.dashboard')
                ->with('error', 'Akses ditolak. Survei Anda sudah dikunci (Status: ' . $survey->status . ').');
        }

        $categories = SurveyCategory::orderBy('id')->get();
        if ($stepNumber < 1 || $stepNumber > $categories->count()) {
            return redirect()->route('school.dashboard');
        }
        $currentCategory = $categories[$stepNumber - 1];
        $currentCategory->load('questions.options');

        // Ambil jawaban saved (codingan sebelumnya)
        $existingAnswers = SurveyAnswer::where('survey_id', $survey->id ?? 0)
            ->pluck('answer_value', key: 'question_id')
            ->toArray();

        return view('school.survey.wizard', [
            'currentStep' => $stepNumber,
            'totalSteps' => $categories->count(),
            'category' => $currentCategory,
            'questions' => $currentCategory->questions,
            'existingAnswers' => $existingAnswers
        ]);
    }

    // 3. Memproses Jawaban Per Step
    public function process(Request $request, $stepNumber)
    {
        $user = Auth::user();
        $survey = Survey::where('school_id', $user->school->id)
            ->where('year', date('Y'))
            // ->where('status', 'draft')
            ->first();

        // 1. Cek apakah survei ada?
        if (!$survey) {
            return redirect()->route('school.dashboard')->with('error', 'Data survei tidak ditemukan.');
        }

        // 2. Cek apakah statusnya valid untuk diedit? (Hanya boleh jika 'draft')
        if ($survey->status !== 'draft') {
            return redirect()->route('school.dashboard')
                ->with('error', 'Gagal menyimpan. Survei sudah berstatus ' . $survey->status);
        }
        
        // Simpan Jawaban
        // Input dari form name="answers[question_id]"
        if ($request->has('answers')) {
            foreach ($request->answers as $questionId => $optionId) {
                SurveyAnswer::updateOrCreate(
                    [
                        'survey_id' => $survey->id,
                        'question_id' => $questionId
                    ],
                    [
                        'answer_value' => $optionId
                    ]
                );
            }
        }

        // Logika Navigasi
        $totalSteps = SurveyCategory::count();

        if ($stepNumber < $totalSteps) {
            // Lanjut ke step berikutnya
            return redirect()->route('school.survey.step', $stepNumber + 1);
        } else {
            // Jika step terakhir, Hitung Skor Final
            $this->calculateFinalScore($survey);
            return redirect()->route('school.dashboard')->with('success', 'Survei selesai! Skor telah diperbarui.');
        }
    }

    // 4. Logika Hitung Skor (Rumus Anda)
    // GANTI method calculateFinalScore dengan yang ini:
    // GANTI method calculateFinalScore dengan yang ini:
    private function calculateFinalScore(Survey $survey)
    {
        $totalObtainedScore = 0; // Poin yang didapat user
        $maxPossibleScore = 0;   // Total poin maksimal jika semua jawaban sempurna (105)

        // Ambil semua pertanyaan beserta opsinya
        $categories = SurveyCategory::with('questions.options')->get();

        foreach ($categories as $category) {
            foreach ($category->questions as $question) {

                // 1. Cari nilai tertinggi dari opsi soal ini (Misal: 5)
                // Ini untuk menghitung penyebut rumus (Max Score)
                $maxQuestionScore = $question->options->max('score_value');
                $maxPossibleScore += $maxQuestionScore;

                // 2. Cari jawaban user
                $answer = SurveyAnswer::where('survey_id', $survey->id)
                    ->where('question_id', $question->id)
                    ->first();

                if ($answer) {
                    // Ambil poin dari opsi yang dipilih
                    $selectedOption = $question->options->where('id', $answer->answer_value)->first();
                    if ($selectedOption) {
                        $totalObtainedScore += $selectedOption->score_value;
                    }
                }
            }
        }

        // 3. Hitung Nilai Akhir (Skala 100)
        // Rumus: (Didapat / Maksimal) * 100
        // Contoh: (82 / 105) * 100 = 78.09
        if ($maxPossibleScore > 0) {
            $finalScore = ($totalObtainedScore / $maxPossibleScore) * 100;
        } else {
            $finalScore = 0;
        }

        // 4. Simpan ke Database
        $survey->update([
            'total_score' => $finalScore,
            'status' => 'submitted'
        ]);

        // Update Profil Sekolah (untuk ranking global)
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
