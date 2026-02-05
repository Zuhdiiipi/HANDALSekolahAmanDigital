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
    // Method step di SurveyController
    public function step($stepNumber)
    {
        $user = Auth::user();

        // Cek Survey
        $survey = Survey::where('school_id', $user->school->id)
            ->where('year', date('Y'))
            ->first();

        // Security Check (Hanya boleh akses jika Draft)
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

        // --- KUNCI AGAR JAWABAN TIDAK HILANG ---
        // Ambil semua jawaban yang pernah diisi di survey ini
        // keyBy('question_id') membuat kita mudah memanggil jawaban berdasarkan ID soal
        $existingAnswers = SurveyAnswer::where('survey_id', $survey->id ?? 0)
            ->get()
            ->keyBy('question_id');
        // ----------------------------------------

        return view('school.survey.wizard', [
            'currentStep' => $stepNumber,
            'totalSteps' => $categories->count(),
            'category' => $currentCategory,
            'questions' => $currentCategory->questions,
            'existingAnswers' => $existingAnswers // Data dikirim ke view
        ]);
    }

    // 3. Memproses Jawaban Per Step
    public function process(Request $request, $stepNumber)
    {
        $user = Auth::user();

        // 1. Cari data survei yang berstatus 'draft' milik sekolah ini
        $survey = Survey::where('school_id', $user->school->id)
            ->where('year', date('Y'))
            ->where('status', 'draft') // Penting: Hanya proses jika status masih draft
            ->first();

        // Security Check: Jika tidak ada survei draft, tendang ke dashboard
        if (!$survey) {
            return redirect()->route('school.dashboard')
                ->with('error', 'Sesi survei tidak ditemukan atau sudah dikunci.');
        }

        // 2. Simpan Jawaban ke Database
        if ($request->has('answers')) {
            foreach ($request->answers as $questionId => $optionId) {

                // A. Cari jawaban lama (jika ada) untuk mengecek logika revisi
                $existingAnswer = SurveyAnswer::where('survey_id', $survey->id)
                    ->where('question_id', $questionId)
                    ->first();

                // B. Tentukan nasib Catatan Validator (validator_note)
                // Defaultnya: Ambil catatan lama (jika ada)
                $noteToSave = $existingAnswer ? $existingAnswer->validator_note : null;

                // C. Logika Penghapusan Catatan:
                // Jika jawaban lama ADA, DAN jawaban yang baru dikirim BERBEDA dengan yang lama...
                // Artinya sekolah sedang melakukan REVISI. Maka hapus catatannya (set null).
                if ($existingAnswer && $existingAnswer->answer_value != $optionId) {
                    $noteToSave = null;
                }

                // D. Simpan / Update Data
                SurveyAnswer::updateOrCreate(
                    [
                        'survey_id'   => $survey->id,
                        'question_id' => $questionId
                    ],
                    [
                        'answer_value'   => $optionId,
                        'validator_note' => $noteToSave // Simpan status catatan yang baru
                    ]
                );
            }
        }

        // 3. Logika Navigasi (Lanjut atau Selesai)
        $totalSteps = SurveyCategory::count();

        if ($stepNumber < $totalSteps) {
            // A. Jika belum step terakhir, lanjut ke step berikutnya
            return redirect()->route('school.survey.step', $stepNumber + 1);
        } else {
            // B. Jika ini step terakhir, Hitung Skor & Finalisasi
            $this->calculateFinalScore($survey);

            // UBAH PESANNYA DI SINI:
            return redirect()->route('school.dashboard')
                ->with('success', 'Asesmen berhasil disubmit! Nilai sementara Anda sudah keluar.');
        }
    }

    // 4. Logika Hitung Skor (Rumus Anda)
    // GANTI method calculateFinalScore dengan yang ini:
    // GANTI method calculateFinalScore dengan yang ini:
    private function calculateFinalScore(Survey $survey)
    {
        $totalObtainedScore = 0; // Total poin yang dikumpulkan sekolah (misal: dapat poin 3, 4, 5...)
        $maxPossibleScore = 0;   // Total poin maksimal jika menjawab sempurna (misal: 5, 5, 5...)

        // Ambil semua pertanyaan
        $categories = SurveyCategory::with('questions.options')->get();

        foreach ($categories as $category) {
            foreach ($category->questions as $question) {

                // 1. Tentukan Nilai Maksimal Soal Ini (Biasanya 5)
                // Kita ambil nilai terbesar dari opsi yang tersedia di soal ini
                $maxQuestionScore = $question->options->max('score_value');

                // Skip jika soal rusak (tidak punya opsi)
                if (!$maxQuestionScore) continue;

                $maxPossibleScore += $maxQuestionScore;

                // 2. Cari Jawaban Sekolah
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

        // 3. Konversi ke Skala 0 - 100
        // Rumus: (Total Didapat / Total Maksimal) * 100
        if ($maxPossibleScore > 0) {
            $finalScore = ($totalObtainedScore / $maxPossibleScore) * 100;
        } else {
            $finalScore = 0;
        }

        // 4. Simpan
        $survey->update([
            'total_score' => $finalScore, // Nilai sudah skala 0-100
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
