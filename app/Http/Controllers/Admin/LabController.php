<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LabController extends Controller
{
    public function index(Request $request)
    {
        $query = Lab::with('head');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        $labs = $query->latest()->paginate(10)->withQueryString();
        return view('admin.lab.index', compact('labs'));
    }

    public function create(): View
    {
        $lecturers = Lecturer::all();
        $staffs    = User::all();
        return view('admin.lab.create', compact('lecturers', 'staffs'));
    }

    public function edit(Lab $lab): View
    {

        $lab->load('tools');
        $lecturers = Lecturer::all();
        $staffs    = User::all();
        return view('admin.lab.edit', compact('lab', 'lecturers', 'staffs'));
    }

    // -------------------------------------------------------------------------
    // STORE
    // -------------------------------------------------------------------------

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'category'        => 'required|in:Praktikum,Riset,Umum',
            'location'        => 'nullable|string|max:255',
            'head_of_lab_id'  => 'nullable|exists:lecturers,id',
            'staff_id'        => 'nullable|exists:users,id',
            'description'     => 'nullable|string',
            'active'          => 'nullable|boolean',
            'image'           => 'nullable|image|mimes:jpeg,png,webp|max:2048',

            // Validasi tools (opsional — boleh tidak diisi)
            'tool_name'         => 'nullable|array',
            'tool_name.*'       => 'nullable|string|max:255',
            'tool_image.*'      => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'tool_description.*'=> 'nullable|string|max:500',
        ]);

        $imagePath = null;

        try {
            // Upload banner lab
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('labs', 'public');
                if (! $imagePath) throw new \RuntimeException('Gagal upload banner lab.');
            }

            DB::transaction(function () use ($request, $imagePath) {

                // Simpan lab
                $lab = Lab::create([
                    'name'           => $request->name,
                    'category'       => $request->category,
                    'location'       => $request->location,
                    'head_of_lab_id' => $request->head_of_lab_id,
                    'staff_id'       => $request->staff_id,
                    'description'    => $request->description,
                    'active'         => $request->boolean('active', true),
                    'image'          => $imagePath,
                    'created_by'     => auth()->id(),
                    'updated_by'     => auth()->id(),
                ]);

                // Simpan tools jika ada yang diisi
                $toolNames = $request->input('tool_name', []);

                foreach ($toolNames as $i => $name) {
                    // Lewati baris yang nama alatnya kosong
                    if (empty(trim($name ?? ''))) continue;

                    $toolImagePath = null;

                    // Upload foto alat per index
                    if ($request->hasFile("tool_image.$i")) {
                        $toolImagePath = $request->file("tool_image.$i")
                            ->store('tools', 'public');
                    }

                    $lab->tools()->create([
                        'name'               => $name,
                        'code'               => null,   // diisi nanti via import Excel
                        'quantity'           => 1,
                        'quantity_available' => 1,
                        'condition'          => 'Baik',
                        'image'              => $toolImagePath,
                        'description'        => $request->input("tool_description.$i"),
                        'active'             => true,
                        'created_by'         => auth()->id(),
                    ]);
                }
            });

            return redirect()
                ->route('labs.index')
                ->with('success', 'Unit Lab berhasil dibuat!');

        } catch (\Throwable $e) {
            // Rollback banner jika DB gagal
            if ($imagePath) Storage::disk('public')->delete($imagePath);

            Log::error('Lab store failed', [
                'user_id' => auth()->id(),
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    // -------------------------------------------------------------------------
    // UPDATE
    // -------------------------------------------------------------------------

    public function update(Request $request, Lab $lab): RedirectResponse
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'category'       => 'required|in:Praktikum,Riset,Umum',
            'location'       => 'nullable|string|max:255',
            'head_of_lab_id' => 'nullable|exists:lecturers,id',
            'staff_id'       => 'nullable|exists:users,id',
            'description'    => 'nullable|string',
            'active'         => 'nullable|boolean',
            'image'          => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            // Tambahkan validasi tools untuk update
            'tool_name'      => 'nullable|array',
        ]);

        $newImagePath = null;
        $oldImagePath = $lab->image;

        try {
            if ($request->hasFile('image')) {
                $newImagePath = $request->file('image')->store('labs', 'public');
            }

            DB::transaction(function () use ($request, $newImagePath, $lab) {
                // 1. Update Data Lab Utama
                $lab->update([
                    'name'           => $request->name,
                    'category'       => $request->category,
                    'location'       => $request->location,
                    'head_of_lab_id' => $request->head_of_lab_id,
                    'staff_id'       => $request->staff_id,
                    'description'    => $request->description,
                    'active'         => $request->boolean('active'),
                    'image'          => $newImagePath ?? $lab->image,
                    'updated_by'     => auth()->id(),
                ]);

                // 2. Sinkronisasi Data Alat (Tools)
                // Strategi paling mudah: Hapus alat lama yang tidak ada di input, lalu simpan yang baru
                // Atau untuk repeater sederhana: Hapus semua alat lama, lalu simpan ulang semua dari form
                
                // Hapus foto-foto alat lama jika perlu (opsional)
                foreach($lab->tools as $oldTool) {
                    // jika Anda ingin menghapus file fisiknya juga
                    // if($oldTool->image) Storage::disk('public')->delete($oldTool->image);
                }
                
                $lab->tools()->delete(); // Hapus semua data alat lama di database

                $toolNames = $request->input('tool_name', []);
                foreach ($toolNames as $i => $name) {
                    if (empty(trim($name ?? ''))) continue;

                    $toolImagePath = null;
                    // Cek jika ada gambar baru diupload, jika tidak gunakan gambar lama (jika sistem mendukung hidden input gambar lama)
                    if ($request->hasFile("tool_image.$i")) {
                        $toolImagePath = $request->file("tool_image.$i")->store('tools', 'public');
                    }

                    $lab->tools()->create([
                        'name'        => $name,
                        'quantity'    => 1,
                        'condition'   => 'Baik',
                        'image'       => $toolImagePath,
                        'description' => $request->input("tool_description.$i"),
                        'created_by'  => auth()->id(),
                    ]);
                }
            });

            if ($newImagePath && $oldImagePath) {
                Storage::disk('public')->delete($oldImagePath);
            }

            return redirect()->route('labs.index')->with('success', 'Unit Lab dan Katalog Alat berhasil diperbarui!');

        } catch (\Throwable $e) {
            if ($newImagePath) Storage::disk('public')->delete($newImagePath);
            Log::error('Lab update failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui data.');
        }
    }

    // -------------------------------------------------------------------------
    // DESTROY
    // -------------------------------------------------------------------------

    public function destroy(Lab $lab): RedirectResponse
    {
        $imagePath = $lab->image;

        try {
            DB::transaction(function () use ($lab) {
                $lab->delete();
            });

            if ($imagePath) Storage::disk('public')->delete($imagePath);

            return back()->with('success', 'Unit Lab berhasil dihapus!');

        } catch (\Throwable $e) {
            Log::error('Lab destroy failed', [
                'user_id' => auth()->id(),
                'lab_id'  => $lab->id,
                'error'   => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal menghapus lab.');
        }
    }
}