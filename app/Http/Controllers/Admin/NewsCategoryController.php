<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    public function index()
    {
        $categories = NewsCategory::withCount('news')->latest()->get();
        return view('admin.news_category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:news_categories,name']);
        
        NewsCategory::create([
            'name' => $request->name,
            'active' => $request->boolean('active', true),
            'created_by' => auth()->id()
        ]);

        return back()->with('success', 'Kategori berhasil dibuat!');
    }


    public function update(Request $request, NewsCategory $newsCategory) {
        $request->validate(['name' => 'required|string|max:100']);
        
        $data = $request->all();
        $data['active'] = $request->boolean('active');
        
        $newsCategory->update($data);
        return back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(NewsCategory $newsCategory) {
        // Cek dulu apakah ada berita di dalamnya
        if ($newsCategory->news()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih berisi berita!');
        }
        $newsCategory->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}