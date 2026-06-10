<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $categoryId = $request->category;

        $news = News::with(['category', 'creator'])
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Hanya tiga kategori yang ditampilkan di dropdown filter
        $allowedCategories = ['Umum', 'Kegiatan Mahasiswa', 'Kegiatan Dosen'];
        $categories = NewsCategory::whereIn('name', $allowedCategories)
            ->where('active', true)
            ->orderBy('name')
            ->get();

        $totalNews = News::count();

        return view('admin.news.index', compact(
            'news',
            'search',
            'totalNews',
            'categories'
        ));
    }

    public function create()
    {
        $newsCategories = [
            'Kegiatan Mahasiswa',
            'Kegiatan Dosen',
            'Umum'
        ];

        $categories = NewsCategory::whereIn('name', $newsCategories)
            ->where('active', true)
            ->get();

        return view('admin.news.create', compact('categories'));
    }

    public function edit(News $news)
    {
        $newsCategories = [
            'Kegiatan Mahasiswa',
            'Kegiatan Dosen',
            'Umum'
        ];

        $categories = NewsCategory::whereIn('name', $newsCategories)
            ->where('active', true)
            ->get();

        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'category_id'  => 'required|exists:news_categories,id',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'published_at' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $validated['active'] = $request->boolean('active');
            $validated['created_by'] = auth()->id();

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')
                    ->store('news', 'public');
            }

            News::create($validated);

            DB::commit();

            return redirect()
                ->route('news.index')
                ->with('success', 'Berita berhasil diterbitkan!');
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Gagal menyimpan berita', [
                'message' => $e->getMessage()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan berita.');
        }
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'category_id'  => 'required|exists:news_categories,id',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'published_at' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();

            $oldImage = $news->image;

            $validated['active'] = $request->boolean('active');
            $validated['updated_by'] = auth()->id();

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')
                    ->store('news', 'public');
            }

            $news->update($validated);

            if ($request->hasFile('image') && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            DB::commit();

            return redirect()
                ->route('news.index')
                ->with('success', 'Berita berhasil diperbarui!');
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Gagal update berita', [
                'message' => $e->getMessage()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui berita.');
        }
    }

    public function destroy(News $news)
    {
        try {
            DB::beginTransaction();

            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            $news->delete();

            DB::commit();

            return redirect()
                ->route('news.index')
                ->with('success', 'Berita berhasil dihapus!');
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Gagal menghapus berita', [
                'message' => $e->getMessage()
            ]);

            return back()
                ->with('error', 'Terjadi kesalahan saat menghapus berita.');
        }
    }
}