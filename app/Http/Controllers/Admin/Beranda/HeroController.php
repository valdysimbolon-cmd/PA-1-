<?php

namespace App\Http\Controllers\Admin\Beranda;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Class HeroController
 *
 * Mengelola data hero (banner utama) pada halaman beranda.
 * Mendukung operasi CRUD, pengaturan status aktif (hanya satu hero aktif),
 * serta validasi input.
 */
class HeroController extends Controller
{
    // -------------------------------------------------------------------------
    // READ (Menampilkan Data)
    // -------------------------------------------------------------------------

    /**
     * Menampilkan daftar semua hero yang tersimpan.
     *
     * @return View
     */
    public function index(): View
    {
        $heroes = Hero::latest()->get();
        return view('admin.hero.index', compact('heroes'));
    }

    /**
     * Menampilkan form tambah hero baru.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.hero.create');
    }

    /**
     * Menampilkan form edit hero tertentu.
     *
     * @param Hero $hero
     * @return View
     */
    public function edit(Hero $hero): View
    {
        return view('admin.hero.edit', compact('hero'));
    }

    // -------------------------------------------------------------------------
    // STORE (Menyimpan Data Baru)
    // -------------------------------------------------------------------------

    /**
     * Menyimpan data hero baru ke database.
     * Jika hero baru diaktifkan, maka hero lain akan dinonaktifkan secara otomatis.
     *
     * @param Request $request
     * @return RedirectResponse
     */
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
                ->with('success', 'Banner baru berhasil ditambahkan.');

        } catch (\Throwable $e) {
            Log::error('Hero store failed', [
                'user_id' => auth()->id(),
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan banner.');
        }
    }

    // -------------------------------------------------------------------------
    // UPDATE (Memperbarui Data)
    // -------------------------------------------------------------------------

    /**
     * Memperbarui data hero yang sudah ada.
     * Jika hero diaktifkan, hero lain akan dinonaktifkan.
     *
     * @param Request $request
     * @param Hero $hero
     * @return RedirectResponse
     */
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
                ->with('success', 'Banner berhasil diperbarui.');

        } catch (\Throwable $e) {
            Log::error('Hero update failed', [
                'user_id' => auth()->id(),
                'hero_id' => $hero->id,
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui banner.');
        }
    }

    // -------------------------------------------------------------------------
    // DESTROY (Menghapus Data)
    // -------------------------------------------------------------------------

    /**
     * Menghapus hero dari database.
     *
     * @param Hero $hero
     * @return RedirectResponse
     */
    public function destroy(Hero $hero): RedirectResponse
    {
        try {
            DB::transaction(function () use ($hero) {
                $hero->delete();
            });

            return back()->with('success', 'Banner berhasil dihapus.');

        } catch (\Throwable $e) {
            Log::error('Hero destroy failed', [
                'user_id' => auth()->id(),
                'hero_id' => $hero->id,
                'error'   => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal menghapus banner.');
        }
    }

    // -------------------------------------------------------------------------
    // TOGGLE ACTIVE (Mengaktifkan Hero)
    // -------------------------------------------------------------------------

    /**
     * Mengaktifkan hero tertentu dan menonaktifkan hero lain yang aktif.
     *
     * @param Hero $hero
     * @return RedirectResponse
     */
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

            // ============================================================
            // PERBAIKAN NOTIFIKASI:
            // - Tidak ada tanda kutip di sekitar judul
            // - Menggunakan kata "Banner" bukan "Hero"
            // - Kalimat lebih ringkas
            // ============================================================
            return back()->with('success', "Banner {$hero->title} berhasil diaktifkan.");

        } catch (\Throwable $e) {
            Log::error('Hero toggleActive failed', [
                'hero_id' => $hero->id,
                'error'   => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal mengaktifkan banner.');
        }
    }
}