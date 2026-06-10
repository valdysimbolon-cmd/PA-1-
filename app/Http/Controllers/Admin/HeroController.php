<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function index() {
        $heroes = Hero::latest()->get();
        return view('admin.hero.index', compact('heroes'));
    }

    public function create() {
        return view('admin.hero.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'subtitle'     => 'required|string',

            'video_url'    => 'nullable|url',

            'poster_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',

            'button_url'   => 'nullable|url',
        ]);

        try {

            DB::beginTransaction();

            $validated['poster_image'] = $request
                ->file('poster_image')
                ->store('heroes/posters', 'public');

            $validated['button_text'] = 'Join Us';

            $isActive = $request->boolean('active');

            if ($isActive) {

                Hero::where('active', true)
                    ->update([
                        'active' => false
                    ]);
            }

            $validated['active'] = $isActive;

            Hero::create($validated);

            DB::commit();

            return redirect()
                ->route('heroes.index')
                ->with('success', 'Hero berhasil ditambahkan.');

        } catch (\Throwable $e) {

            DB::rollBack();

            if (
                isset($validated['poster_image']) &&
                Storage::disk('public')->exists($validated['poster_image'])
            ) {
                Storage::disk('public')->delete($validated['poster_image']);
            }

            Log::error('Hero Store Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }
    public function edit(Hero $hero) {
        return view('admin.hero.edit', compact('hero'));
    }

    public function update(Request $request, Hero $hero)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'subtitle'     => 'required|string',

            'video_url'    => 'nullable|url',

            'poster_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'button_url'   => 'nullable|url',
        ]);

        try {

            DB::beginTransaction();

            $isActive = $request->boolean('active');

            if ($isActive) {

                Hero::where('id', '!=', $hero->id)
                    ->update([
                        'active' => false
                    ]);
            }

            $validated['active'] = $isActive;
            $validated['button_text'] = 'Join Us';

            if ($request->hasFile('poster_image')) {

                if (
                    $hero->poster_image &&
                    Storage::disk('public')->exists($hero->poster_image)
                ) {
                    Storage::disk('public')
                        ->delete($hero->poster_image);
                }

                $validated['poster_image'] = $request
                    ->file('poster_image')
                    ->store('heroes/posters', 'public');
            }

            $hero->update($validated);

            DB::commit();

            return redirect()
                ->route('heroes.index')
                ->with('success', 'Hero berhasil diperbarui.');

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Hero Update Error', [
                'hero_id' => $hero->id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy(Hero $hero)
    {
        try {

            DB::beginTransaction();

            if (
                $hero->poster_image &&
                Storage::disk('public')->exists($hero->poster_image)
            ) {
                Storage::disk('public')
                    ->delete($hero->poster_image);
            }

            $hero->delete();

            DB::commit();

            return back()
                ->with('success', 'Hero berhasil dihapus.');

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Hero Delete Error', [
                'hero_id' => $hero->id,
                'message' => $e->getMessage(),
            ]);

            return back()
                ->with('error', 'Gagal menghapus Hero.');
        }
    }
}