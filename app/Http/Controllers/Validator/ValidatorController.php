<?php

namespace App\Http\Controllers\Validator;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountRejected;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyCategory;

class ValidatorController extends Controller
{
    public function index()
    {
        $registrations = Registration::where('status', 'pending')->latest()->get();

        // TAMBAHAN: Ambil survei yang statusnya 'submitted'
        $submittedSurveys = Survey::with('school')
            ->where('status', 'submitted')
            ->latest()
            ->get();

        return view('validator.dashboard', compact('registrations', 'submittedSurveys'));
    }

    public function verifySurvey($id)
    {
        $survey = Survey::with('school')->findOrFail($id);

        // Ambil semua kategori + pertanyaan + opsi
        $categories = SurveyCategory::with(['questions.options'])->get();

        // Ambil jawaban sekolah, map berdasarkan question_id biar mudah dipanggil di View
        $answers = SurveyAnswer::where('survey_id', $id)
            ->get()
            ->keyBy('question_id');

        return view('validator.verify', compact('survey', 'categories', 'answers'));
    }

    public function storeVerification(Request $request, $id)
    {
        $survey = Survey::findOrFail($id);

        // 1. Simpan semua catatan validator (baik diterima maupun ditolak)
        if ($request->has('notes')) {
            foreach ($request->notes as $questionId => $note) {
                // Cari jawaban yang sesuai
                $answer = SurveyAnswer::where('survey_id', $id)
                    ->where('question_id', $questionId)
                    ->first();

                if ($answer) {
                    $answer->update([
                        'validator_note' => $note
                    ]);
                }
            }
        }

        // 2. Cek tombol mana yang diklik
        if ($request->action === 'reject') {
            // JIKA DITOLAK:
            // Kembalikan status ke 'draft' agar Sekolah bisa mengedit kembali
            $survey->update(['status' => 'draft']);

            return redirect()->route('validator.dashboard')
                ->with('warning', 'Asesmen dikembalikan ke sekolah untuk perbaikan.');
        } else {
            // JIKA DITERIMA:
            // Ubah status ke 'verified' (Final)
            $survey->update(['status' => 'verified']);

            return redirect()->route('validator.dashboard')
                ->with('success', 'Asesmen berhasil diverifikasi dan nilai telah dikunci.');
        }
    }

    public function show($id)
    {
        $registration = Registration::findOrFail($id);
        return view('validator.show', compact('registration'));
    }

    // --- LOGIKA BARU: APPROVE HANYA VERIFIKASI ---
    public function approve($id)
    {
        $reg = Registration::findOrFail($id);

        // Ubah status jadi 'verified' agar masuk ke dashboard Admin
        $reg->update(['status' => 'verified']);

        return redirect()->route('validator.dashboard')
            ->with('success', 'Data telah diverifikasi dan diteruskan ke Admin untuk pembuatan akun.');
    }

    // --- LOGIKA REJECT (TETAP SAMA) ---
    public function reject(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string']);
        $reg = Registration::findOrFail($id);

        $reg->update([
            'status' => 'rejected',
            'admin_notes' => $request->reason
        ]);

        // Kirim Email Penolakan
        try {
            Mail::to($reg->email)->send(new AccountRejected($reg, $request->reason));
        } catch (\Exception $e) {
            return redirect()->route('validator.dashboard')
                ->with('warning', 'Ditolak, tapi email gagal terkirim.');
        }

        return redirect()->route('validator.dashboard')->with('success', 'Pendaftaran ditolak.');
    }
}
