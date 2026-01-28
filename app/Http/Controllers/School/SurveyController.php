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

        if ($existingSurvey && $existingSurvey->status === 'submitted') {
            return redirect()->route('school.dashboard')
                ->with('error', 'Anda sudah menyelesaikan asesmen tahun ini. Hubungi Admin jika ingin revisi.');
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

        if ($survey && $survey->status === 'submitted') {
            return redirect()->route('school.dashboard')->with('error', 'Akses ditolak. Survei sudah dikunci.');
        }

        // ... (Kode selanjutnya sama seperti sebelumnya) ...
        $categories = SurveyCategory::orderBy('id')->get();
        if ($stepNumber < 1 || $stepNumber > $categories->count()) {
            return redirect()->route('school.dashboard');
        }
        $currentCategory = $categories[$stepNumber - 1];
        $currentCategory->load('questions.options');

        // Ambil jawaban saved (codingan sebelumnya)
        $existingAnswers = SurveyAnswer::where('survey_id', $survey->id ?? 0)
            ->pluck('answer_value', 'question_id')
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
            ->where('status', 'draft')
            ->firstOrFail();

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
    private function calculateFinalScore(Survey $survey)
    {
        $totalFinalScore = 0;
        $categories = SurveyCategory::with('questions.options')->get();

        foreach ($categories as $category) {
            $categoryScore = 0;

            foreach ($category->questions as $question) {
                // Ambil jawaban user dari DB
                $answer = SurveyAnswer::where('survey_id', $survey->id)
                    ->where('question_id', $question->id)
                    ->first();

                if ($answer) {
                    // Cari opsi yang dipilih untuk tahu skornya (misal: Ya=100)
                    $option = $question->options->where('id', $answer->answer_value)->first();
                    $scoreVal = $option ? $option->score_value : 0;

                    // Rumus: Skor Opsi * (Bobot Soal / 100)
                    // Contoh: Dapat 100 * (100% bobot soal) = 100 poin
                    $categoryScore += ($scoreVal * ($question->weight / 100));
                }
            }

            // Rumus Akhir: Total Skor Kategori * (Bobot Kategori / 100)
            // Contoh: Poin Kategori 100 * (40% bobot kategori) = 40 Poin Final
            $totalFinalScore += ($categoryScore * ($category->weight / 100));
        }

        // Simpan Hasil
        $survey->update([
            'total_score' => $totalFinalScore,
            'status' => 'submitted'
        ]);

        // Update Profil Sekolah & Cache
        $survey->school->update(['current_score' => $totalFinalScore]);
        Cache::forget('school_rankings');
    }
}
