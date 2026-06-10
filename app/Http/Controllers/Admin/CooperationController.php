<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cooperation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CooperationController extends Controller
{
    public function index(Request $request)
    {
        $query = Cooperation::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $cooperations = $query->latest()->paginate(10)->withQueryString();

        return view('admin.cooperation.index', compact('cooperations'));
    }

    public function create()
    {
        return view('admin.cooperation.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'type' => ['required', Rule::in(['Industri','Akademik','Pemerintah'])],
            'logo' => 'nullable|image|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('logo')) {
                $validated['logo'] = $request->file('logo')->store('cooperations', 'public');
            }

            $validated['active'] = $request->boolean('active');

            Cooperation::create($validated);

            DB::commit();

            return redirect()
                ->route('cooperations.index')
                ->with('success', 'Kerja sama berhasil ditambahkan');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menyimpan data');
        }
    }

    public function update(Request $request, Cooperation $cooperation)
    {
        $validated = $request->validate([
            'name' => 'required',
            'type' => ['required', Rule::in(['Industri','Akademik','Pemerintah'])],
            'logo' => 'nullable|image|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $oldLogo = $cooperation->logo;

            if ($request->hasFile('logo')) {
                $validated['logo'] = $request->file('logo')->store('cooperations', 'public');
            }

            $validated['active'] = $request->boolean('active');

            $cooperation->update($validated);

            if ($request->hasFile('logo') && $oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            DB::commit();

            return redirect()
                ->route('cooperations.index')
                ->with('success', 'Kerja sama berhasil diupdate');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal update data');
        }
    }

    public function destroy(Cooperation $cooperation)
    {
        try {
            DB::beginTransaction();

            if ($cooperation->logo) {
                Storage::disk('public')->delete($cooperation->logo);
            }

            $cooperation->delete();

            DB::commit();

            return redirect()
                ->route('cooperations.index')
                ->with('success', 'Kerja sama berhasil dihapus');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menghapus data');
        }
    }

    public function edit(Cooperation $cooperation)
    {
        return view('admin.cooperation.edit', compact('cooperation'));
    }
}