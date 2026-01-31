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
        ]);

        // FIX: Manual input weight = 0 agar database tidak error
        SurveyCategory::create([
            'name' => $request->name,
            'weight' => 0
        ]);

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
        ]);

        // FIX: Manual update
        $category->update([
            'name' => $request->name,
            'weight' => 0
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori diperbarui.');
    }

    public function destroy(SurveyCategory $category)
    {
        if ($category->questions()->count() > 0) {
            return back()->with('error', 'Gagal hapus. Kategori ini memiliki pertanyaan.');
        }
        $category->delete();
        return back()->with('success', 'Kategori dihapus.');
    }
}
