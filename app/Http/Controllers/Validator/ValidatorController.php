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

        $submittedSurveys = Survey::with('school')
            ->where('status', 'submitted')
            ->latest()
            ->get();

        return view('validator.dashboard', compact('registrations', 'submittedSurveys'));
    }

    public function verifySurvey($id)
    {
        $survey = Survey::with('school')->findOrFail($id);

        $categories = SurveyCategory::with(['questions.options'])->get();
        $answers = SurveyAnswer::where('survey_id', $id)
            ->get()
            ->keyBy('question_id');

        return view('validator.verify', compact('survey', 'categories', 'answers'));
    }

    public function storeVerification(Request $request, $id)
    {
        $survey = Survey::findOrFail($id);
        if ($request->has('notes')) {
            foreach ($request->notes as $questionId => $note) {
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
        if ($request->action === 'reject') {
            $survey->update(['status' => 'draft']);

            return redirect()->route('validator.dashboard')
                ->with('warning', 'Asesmen dikembalikan ke sekolah untuk perbaikan.');
        } else {
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
    public function approve($id)
    {
        $reg = Registration::findOrFail($id);
        $reg->update(['status' => 'verified']);

        return redirect()->route('validator.dashboard')
            ->with('success', 'Data telah diverifikasi dan diteruskan ke Admin untuk pembuatan akun.');
    }
    public function reject(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string']);
        $reg = Registration::findOrFail($id);

        $reg->update([
            'status' => 'rejected',
            'admin_notes' => $request->reason
        ]);
        try {
            Mail::to($reg->email)->send(new AccountRejected($reg, $request->reason));
        } catch (\Exception $e) {
            return redirect()->route('validator.dashboard')
                ->with('warning', 'Ditolak, tapi email gagal terkirim.');
        }

        return redirect()->route('validator.dashboard')->with('success', 'Pendaftaran ditolak.');
    }
}
