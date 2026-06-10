<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class NewsCategoryController extends Controller
{
    public function index()
    {
        $categories = NewsCategory::withCount('news')
            ->latest()
            ->get();

        return view('admin.news_category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:news_categories,name',
        ]);

        try {
            DB::beginTransaction();

            $validated['active'] = $request->boolean('active');
            $validated['created_by'] = auth()->id();

            NewsCategory::create($validated);

            DB::commit();

            return back()->with(
                'success',
                'Kategori berhasil dibuat!'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Gagal membuat kategori berita', [
                'message' => $e->getMessage()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat kategori.');
        }
    }

    public function update(Request $request, NewsCategory $newsCategory)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('news_categories', 'name')
                    ->ignore($newsCategory->id)
            ],
        ]);

        try {
            DB::beginTransaction();

            $validated['active'] = $request->boolean('active');
            $validated['updated_by'] = auth()->id();

            $newsCategory->update($validated);

            DB::commit();

            return back()->with(
                'success',
                'Kategori berhasil diperbarui!'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Gagal update kategori berita', [
                'message' => $e->getMessage()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui kategori.');
        }
    }

    public function destroy(NewsCategory $newsCategory)
    {
        try {
            DB::beginTransaction();

            if ($newsCategory->news()->exists()) {

                DB::rollBack();

                return back()->with(
                    'error',
                    'Kategori tidak bisa dihapus karena masih memiliki berita.'
                );
            }

            $newsCategory->delete();

            DB::commit();

            return back()->with(
                'success',
                'Kategori berhasil dihapus!'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Gagal menghapus kategori berita', [
                'message' => $e->getMessage()
            ]);

            return back()->with(
                'error',
                'Terjadi kesalahan saat menghapus kategori.'
            );
        }
    }
}