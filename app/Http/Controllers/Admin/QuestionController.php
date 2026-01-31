<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveyCategory;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = SurveyQuestion::with('category')->latest()->get();
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $categories = SurveyCategory::all();
        return view('admin.questions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'category_id' => 'required|exists:survey_categories,id',
            'question_text' => 'required|string',
            // 'type' dihapus dari validasi karena kita hardcode di bawah
            // 'weight' dihapus dari validasi

            // Opsi Jawaban Wajib Ada
            'options' => 'required|array|min:2',
            'options.*.text' => 'required',
            'options.*.score' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request) {
            // 2. Simpan Soal
            $question = SurveyQuestion::create([
                'category_id' => $request->category_id,
                'question_text' => $request->question_text,
                'type' => 'mcq', // FIX: Typo 'mqc' -> 'mcq'
                'weight' => 0,   // FIX: Set default 0
            ]);

            // 3. Simpan Opsi
            foreach ($request->options as $opt) {
                SurveyQuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $opt['text'],
                    'score_value' => $opt['score'],
                ]);
            }
        });

        return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan disimpan.');
    }

    public function edit($id)
    {
        $question = SurveyQuestion::with('options')->findOrFail($id);
        $categories = SurveyCategory::all();
        return view('admin.questions.edit', compact('question', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $question = SurveyQuestion::findOrFail($id);

        $request->validate([
            'category_id' => 'required',
            'question_text' => 'required',
            // 'weight' dihapus dari validasi
            'options' => 'required|array|min:2',
            'options.*.text' => 'required',
            'options.*.score' => 'required',
        ]);

        DB::transaction(function () use ($request, $question) {
            // 1. Update Soal
            $question->update([
                'category_id' => $request->category_id,
                'question_text' => $request->question_text,
                'weight' => 0, // Pastikan tetap 0 atau nilai lama
            ]);

            // 2. Update Opsi (Hapus lama, buat baru)
            $question->options()->delete();

            foreach ($request->options as $opt) {
                SurveyQuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $opt['text'],
                    'score_value' => $opt['score'],
                ]);
            }
        });

        return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan diperbarui.');
    }

    public function destroy($id)
    {
        $question = SurveyQuestion::findOrFail($id);
        $question->options()->delete();
        $question->delete();
        return back()->with('success', 'Pertanyaan dihapus.');
    }
}
