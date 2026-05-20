<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::with('category')->latest()->get();
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = NewsCategory::where('active', 1)->get();
        return view('admin.news.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:news_categories,id',
            'title'       => 'required|string|max:255',
            'content'     => 'required',
            'image'       => 'nullable|image|max:2048',
            'published_at'        => 'required|date',
        ]);

        $data = $request->all();
        $data['active'] = $request->boolean('active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('news.index')->with('success', 'Berita berhasil diterbitkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $categories = NewsCategory::where('active', 1)->get();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        // 1. Validasi
        $request->validate([
            'category_id' => 'required|exists:news_categories,id',
            'title'       => 'required|string|max:255',
            'content'     => 'required',
            'image'       => 'nullable|image|max:2048',
            'published_at'=> 'required|date',
        ]);

        $data = $request->all();
        $data['active'] = $request->boolean('active');

        // 2. Logika Update Gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama agar storage tidak penuh sampah
            if ($news->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($news->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        // 3. Eksekusi Perubahan
        $news->update($data);

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        if ($news->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($news->image);
        }
        $news->delete();

        return redirect()->route('news.index')->with('success', 'Berita telah dihapus selamanya.');
    }
}
