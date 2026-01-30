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
        // Tampilkan soal dikelompokkan per kategori
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
            'type' => 'required|in:mcq,checkbox,number,text', // <--- TAMBAHAN VALIDASI
            'weight' => 'required|numeric',

            // Validasi Opsi: HANYA WAJIB JIKA TIPE 'mcq' atau 'checkbox'
            'options' => 'required_if:type,mcq,checkbox|array',
            'options.*.text' => 'required_with:options',
            'options.*.score' => 'required_with:options',
        ]);

        DB::transaction(function () use ($request) {
            // 2. Simpan Soal (Sertakan TYPE)
            $question = SurveyQuestion::create([
                'category_id' => $request->category_id,
                'question_text' => $request->question_text,
                'type' => $request->type, // <--- SIMPAN TIPE SOAL
                'weight' => $request->weight,
            ]);

            // 3. Simpan Opsi (Hanya jika tipe mcq/checkbox)
            if (in_array($request->type, ['mcq', 'checkbox']) && $request->has('options')) {
                foreach ($request->options as $opt) {
                    SurveyQuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $opt['text'],
                        'score_value' => $opt['score'],
                    ]);
                }
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
            'weight' => 'required|numeric',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required',
            'options.*.score' => 'required',
        ]);

        DB::transaction(function () use ($request, $question) {
            // 1. Update Soal
            $question->update([
                'category_id' => $request->category_id,
                'question_text' => $request->question_text,
                'weight' => $request->weight,
            ]);

            // 2. Update Opsi (Cara Aman: Hapus semua opsi lama, buat baru)
            // Ini menghindari kerumitan mencocokkan ID opsi di frontend
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
        $question->options()->delete(); // Hapus opsi dulu
        $question->delete(); // Hapus soal
        return back()->with('success', 'Pertanyaan dihapus.');
    }
}
