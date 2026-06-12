<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class HeroController extends Controller
{
    // -------------------------------------------------------------------------
    // READ
    // -------------------------------------------------------------------------

    public function index(): View
    {
        $heroes = Hero::latest()->get();
        return view('admin.hero.index', compact('heroes'));
    }

    public function create(): View
    {
        return view('admin.hero.create');
    }

    public function edit(Hero $hero): View
    {
        return view('admin.hero.edit', compact('hero'));
    }

    // -------------------------------------------------------------------------
    // STORE
    // -------------------------------------------------------------------------

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'                 => 'required|string|max:255',
            'subtitle'              => 'required|string',
            'video_url'             => 'nullable|url',
            'primary_button_text'   => 'nullable|string|max:100',
            'primary_button_url'    => 'nullable|url',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_url'  => 'nullable|url',
            'active'                => 'nullable|boolean',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $isActive = $request->boolean('active');

                // Nonaktifkan semua hero lain jika hero baru diset aktif
                if ($isActive) {
                    Hero::where('active', true)->update(['active' => false]);
                }

                Hero::create([
                    'title'                 => $request->title,
                    'subtitle'              => $request->subtitle,
                    'video_url'             => $request->video_url,
                    'primary_button_text'   => $request->primary_button_text,
                    'primary_button_url'    => $request->primary_button_url,
                    'secondary_button_text' => $request->secondary_button_text,
                    'secondary_button_url'  => $request->secondary_button_url,
                    'active'                => $isActive,
                    'created_by'            => auth()->id(),
                    'updated_by'            => auth()->id(),
                ]);
            });

            return redirect()
                ->route('heroes.index')
                ->with('success', 'Hero berhasil ditambahkan.');

        } catch (\Throwable $e) {
            Log::error('Hero store failed', [
                'user_id' => auth()->id(),
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan hero.');
        }
    }

    // -------------------------------------------------------------------------
    // UPDATE
    // -------------------------------------------------------------------------

    public function update(Request $request, Hero $hero): RedirectResponse
    {
        $request->validate([
            'title'                 => 'required|string|max:255',
            'subtitle'              => 'required|string',
            'video_url'             => 'nullable|url',
            'primary_button_text'   => 'nullable|string|max:100',
            'primary_button_url'    => 'nullable|url',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_url'  => 'nullable|url',
            'active'                => 'nullable|boolean',
        ]);

        try {
            DB::transaction(function () use ($request, $hero) {
                $isActive = $request->boolean('active');

                // Nonaktifkan hero lain jika hero ini diset aktif
                if ($isActive) {
                    Hero::where('id', '!=', $hero->id)
                        ->where('active', true)
                        ->update(['active' => false]);
                }

                $hero->update([
                    'title'                 => $request->title,
                    'subtitle'              => $request->subtitle,
                    'video_url'             => $request->video_url,
                    'primary_button_text'   => $request->primary_button_text,
                    'primary_button_url'    => $request->primary_button_url,
                    'secondary_button_text' => $request->secondary_button_text,
                    'secondary_button_url'  => $request->secondary_button_url,
                    'active'                => $isActive,
                    'updated_by'            => auth()->id(),
                ]);
            });

            return redirect()
                ->route('heroes.index')
                ->with('success', 'Hero berhasil diperbarui.');

        } catch (\Throwable $e) {
            Log::error('Hero update failed', [
                'user_id' => auth()->id(),
                'hero_id' => $hero->id,
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui hero.');
        }
    }

    // -------------------------------------------------------------------------
    // DESTROY
    // -------------------------------------------------------------------------

    public function destroy(Hero $hero): RedirectResponse
    {
        try {
            DB::transaction(function () use ($hero) {
                $hero->delete();
            });

            return back()->with('success', 'Hero berhasil dihapus.');

        } catch (\Throwable $e) {
            Log::error('Hero destroy failed', [
                'user_id' => auth()->id(),
                'hero_id' => $hero->id,
                'error'   => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal menghapus hero.');
        }
    }

    // -------------------------------------------------------------------------
    // TOGGLE ACTIVE
    // -------------------------------------------------------------------------

    public function toggleActive(Hero $hero): RedirectResponse
    {
        try {
            DB::transaction(function () use ($hero) {
                Hero::where('active', true)->update(['active' => false]);
                $hero->update([
                    'active'     => true,
                    'updated_by' => auth()->id(),
                ]);
            });

            return back()->with('success', "\"{$hero->title}\" sekarang aktif di beranda.");

        } catch (\Throwable $e) {
            Log::error('Hero toggleActive failed', [
                'hero_id' => $hero->id,
                'error'   => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal mengaktifkan hero.');
        }
    }
}