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
        if (!$user->school) {
            return back()->with('error', 'Profil sekolah belum ada.');
        }

        // Cek apakah ada draft tahun ini, jika tidak buat baru
        $survey = Survey::firstOrCreate(
            ['school_id' => $user->school->id, 'year' => date('Y'), 'status' => 'draft'],
            ['total_score' => 0]
        );

        return redirect()->route('school.survey.step', 1);
    }

    // 2. Menampilkan Pertanyaan Per Kategori (Step)
    public function step($stepNumber)
    {
        // Ambil semua kategori, urutkan berdasarkan ID
        $categories = SurveyCategory::orderBy('id')->get();

        // Cek apakah step valid
        if ($stepNumber < 1 || $stepNumber > $categories->count()) {
            return redirect()->route('school.dashboard');
        }

        // Ambil kategori sesuai step (Ingat array mulai dari index 0, jadi step-1)
        $currentCategory = $categories[$stepNumber - 1];

        // Ambil soal & opsi untuk kategori ini
        $currentCategory->load('questions.options');

        return view('school.survey.wizard', [
            'currentStep' => $stepNumber,
            'totalSteps' => $categories->count(),
            'category' => $currentCategory, // Kirim objek kategori lengkap
            'questions' => $currentCategory->questions
        ]);
    }

    // 3. Memproses Jawaban Per Step
    public function process(Request $request, $stepNumber)
    {
        $user = Auth::user();
        $survey = Survey::where('school_id', $user->school->id)
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
