<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveyCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = SurveyCategory::withCount('questions')->orderBy('id')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0|max:100', // Bobot dalam %
        ]);

        SurveyCategory::create($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(SurveyCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, SurveyCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0|max:100',
        ]);

        $category->update($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Kategori diperbarui.');
    }

    public function destroy(SurveyCategory $category)
    {
        // Opsional: Cek jika ada soal, jangan dihapus
        if ($category->questions()->count() > 0) {
            return back()->with('error', 'Gagal hapus. Kategori ini memiliki pertanyaan.');
        }
        $category->delete();
        return back()->with('success', 'Kategori dihapus.');
    }
}
