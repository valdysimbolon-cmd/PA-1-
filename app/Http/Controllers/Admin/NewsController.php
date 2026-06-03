<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('category', 'creator')->latest()->get();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = NewsCategory::where('active', 1)->get();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:news_categories,id',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'required|date',
        ]);

        $data = $request->all();
        $data['active'] = $request->boolean('active', true);
        $data['created_by'] = auth()->id(); // Audit Trail

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);
        return redirect()->route('news.index')->with('success', 'Berita berhasil diterbitkan!');
    }

    public function edit(News $news)
    {
        $categories = NewsCategory::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $data = $request->all();
        $data['active'] = $request->boolean('active');
        $data['updated_by'] = auth()->id(); // Audit Trail

        if ($request->hasFile('image')) {
            if ($news->image) Storage::disk('public')->delete($news->image);
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);
        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(News $news)
    {
        if ($news->image) Storage::disk('public')->delete($news->image);
        $news->delete();
        return back()->with('success', 'Berita dihapus!');
    }
}