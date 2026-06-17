<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{
    /**
     * Daftar Fasilitas
     */
    public function index(Request $request)
    {
        $query = Facility::query();

        // Filter pencarian (nama / lokasi)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        // Filter tipe
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $facilities = $query->latest()->paginate(10)->withQueryString();

        // Kirim daftar tipe unik untuk dropdown filter
        $types = Facility::select('type')->distinct()->pluck('type');

        return view('admin.facility.index', compact('facilities', 'types'));
    }

    /**
     * Form Tambah Fasilitas
     */
    public function create()
    {
        return view('admin.facility.create');
    }

    /**
     * Simpan Fasilitas
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'capacity'    => 'nullable|integer|min:0',
            'location'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {

            $data = [
                'name'        => $request->name,
                'type'        => $request->type,
                'capacity'    => $request->capacity,
                'location'    => $request->location,
                'description' => $request->description,
                'active'      => $request->boolean('active'),
                'created_by'  => Auth::id(),
            ];

            if ($request->hasFile('image')) {
                $data['image'] = $request
                    ->file('image')
                    ->store('facilities', 'public');
            }

            Facility::create($data);

            DB::commit();

            return redirect()
                ->route('facilities.index')
                ->with(
                    'success',
                    'Fasilitas berhasil ditambahkan.'
                );

        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Gagal menyimpan fasilitas', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Terjadi kesalahan saat menyimpan fasilitas.'
                );
        }
    }

    /**
     * Form Edit Fasilitas
     */
    public function edit(Facility $facility)
    {
        return view(
            'admin.facility.edit',
            compact('facility')
        );
    }

    /**
     * Update Fasilitas
     */
    public function update(
        Request $request,
        Facility $facility
    ) {
        $request->validate([
            'name'        => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'capacity'    => 'nullable|integer|min:0',
            'location'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {

            $data = [
                'name'        => $request->name,
                'type'        => $request->type,
                'capacity'    => $request->capacity,
                'location'    => $request->location,
                'description' => $request->description,
                'active'      => $request->boolean('active'),
                'updated_by'  => Auth::id(),
            ];

            if ($request->hasFile('image')) {

                if (
                    $facility->image &&
                    Storage::disk('public')->exists(
                        $facility->image
                    )
                ) {
                    Storage::disk('public')->delete(
                        $facility->image
                    );
                }

                $data['image'] = $request
                    ->file('image')
                    ->store('facilities', 'public');
            }

            $facility->update($data);

            DB::commit();

            return redirect()
                ->route('facilities.index')
                ->with(
                    'success',
                    'Data fasilitas berhasil diperbarui.'
                );

        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Gagal memperbarui fasilitas', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Terjadi kesalahan saat memperbarui fasilitas.'
                );
        }
    }

    /**
     * Hapus Fasilitas
     */
    public function destroy(Facility $facility)
    {
        DB::beginTransaction();

        try {

            if (
                $facility->image &&
                Storage::disk('public')->exists(
                    $facility->image
                )
            ) {
                Storage::disk('public')->delete(
                    $facility->image
                );
            }

            $facility->delete();

            DB::commit();

            return redirect()
                ->route('facilities.index')
                ->with(
                    'success',
                    'Fasilitas berhasil dihapus.'
                );

        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Gagal menghapus fasilitas', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return redirect()
                ->route('facilities.index')
                ->with(
                    'error',
                    'Fasilitas gagal dihapus.'
                );
        }
    }
}