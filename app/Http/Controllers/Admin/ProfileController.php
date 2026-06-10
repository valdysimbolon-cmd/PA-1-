<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $query = Profile::latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('key', 'like', '%' . $request->search . '%');
        }

        $profiles = $query->paginate(10)->withQueryString();

        return view('admin.profile.index', compact('profiles'));
    }

    public function create()
    {
        return view('admin.profile.create');
    }

    private function cleanEditorHtml($html)
    {
        $html = preg_replace('/<p>(&nbsp;|\s)*<\/p>/', '', $html);
        $html = preg_replace('/<p>\s*<\/p>/', '', $html);
        return trim($html);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:profiles,key',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $validated['description'] = $this->cleanEditorHtml($validated['description']);
            $validated['active'] = $request->boolean('active');

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('profiles', 'public');
            }

            Profile::create($validated);

            DB::commit();

            return redirect()
                ->route('profiles.index')
                ->with('success', 'Profile berhasil ditambahkan');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Profile error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function edit(Profile $profile)
    {
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $oldImage = $profile->image;

            $validated['description'] = $this->cleanEditorHtml($validated['description']);
            $validated['active'] = $request->boolean('active');

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('profiles', 'public');
            }

            $profile->update($validated);

            if ($request->hasFile('image') && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            DB::commit();

            return redirect()
                ->route('profiles.index')
                ->with('success', 'Profile berhasil diupdate');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Profile error', [
    'message' => $e->getMessage(),
    'line' => $e->getLine(),
]);

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat update data.');
        }
    }

    public function destroy(Profile $profile)
    {
        try {
            DB::beginTransaction();

            if ($profile->image) {
                Storage::disk('public')->delete($profile->image);
            }

            $profile->delete();

            DB::commit();

            return redirect()
                ->route('profiles.index')
                ->with('success', 'Profile berhasil dihapus');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menghapus data.');
        }
    }
}