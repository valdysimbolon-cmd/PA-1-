<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class LecturerController extends Controller
{
    /**
     * Menampilkan daftar seluruh dosen & staff
     */
    public function index(Request $request)
    {
        $query = Lecturer::with('leader');

        // Filter pencarian (nama atau NIP)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('nip_nidn', 'like', "%{$search}%");
            });
        }

        // Filter tipe (dosen/staff) berdasarkan academic_position
        if ($request->filled('type')) {
            if ($request->type == 'dosen') {
                $dosenPositions = ['Tenaga Pengajar', 'Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar'];
                $query->whereIn('academic_position', $dosenPositions);
            } elseif ($request->type == 'staff') {
                $staffPositions = ['Laboran', 'Teknisi', 'Staff Administrasi', 'Lainnya'];
                $query->whereIn('academic_position', $staffPositions);
            }
        }

        $lecturers = $query->latest()->paginate(10)->withQueryString();

        return view('admin.lecturer.index', compact('lecturers'));
    }

    /**
     * Form tambah personel baru
     */
    public function create()
    {
        // Ambil data untuk pilihan atasan langsung (organogram)
        $leaders = Lecturer::orderBy('name', 'asc')->get();
        return view('admin.lecturer.create', compact('leaders'));
    }

    /**
     * Proses simpan data dosen & riwayat pendidikan
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip_nidn' => 'required|unique:lecturers,nip_nidn',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:lecturers,email',
            'academic_position' => 'required',
            'sinta_url' => 'nullable|url',
            'pddikti_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'degree.*' => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['active'] = $request->boolean('active'); 
            $data['created_by'] = Auth::id();
            
            // PERBAIKAN: Pastikan parent_id jadi null jika kosong
            $data['parent_id'] = $request->parent_id ?: null;

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('lecturers', 'public');
            }

            $lecturer = Lecturer::create($data);

            if ($request->has('degree')) {
                foreach ($request->degree as $key => $degree) {
                    if (!empty($degree)) {
                        $lecturer->educations()->create([
                            'degree'          => $degree,
                            'campus'          => $request->campus[$key] ?? null,
                            'study_program'   => $request->study_program[$key] ?? null,
                            'graduation_year' => $request->graduation_year[$key] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('lecturers.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal simpan dosen: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan data.');
        }
    }

    /**
     * Form edit personel
     */
    public function edit(Lecturer $lecturer)
    {
        $leaders = Lecturer::where('id', '!=', $lecturer->id)->orderBy('name', 'asc')->get();
        return view('admin.lecturer.edit', compact('lecturer', 'leaders'));
    }

    /**
     * Proses update data personel
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        $request->validate([
            'nip_nidn' => 'required|unique:lecturers,nip_nidn,' . $lecturer->id,
            'name' => 'required|string|max:255', // TAMBAHKAN INI (Tadi Hilang)
            'email' => 'required|email|unique:lecturers,email,' . $lecturer->id, // HAPUS DOUBLE-NYA
            'academic_position' => 'required',
            'sinta_url' => 'nullable|url',
            'pddikti_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['active'] = $request->boolean('active');
            $data['updated_by'] = Auth::id();
            
            // PERBAIKAN: Pastikan parent_id jadi null jika kosong
            $data['parent_id'] = $request->parent_id ?: null;

            if ($request->hasFile('image')) {
                if ($lecturer->image && Storage::disk('public')->exists($lecturer->image)) {
                    Storage::disk('public')->delete($lecturer->image);
                }
                $data['image'] = $request->file('image')->store('lecturers', 'public');
            }

            $lecturer->update($data);

            // Update Pendidikan (Clean Slate)
            $lecturer->educations()->delete();
            if ($request->has('degree')) {
                foreach ($request->degree as $key => $degree) {
                    if (!empty($degree)) {
                        $lecturer->educations()->create([
                            'degree'          => $degree,
                            'campus'          => $request->campus[$key] ?? null,
                            'study_program'   => $request->study_program[$key] ?? null,
                            'graduation_year' => $request->graduation_year[$key] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('lecturers.index')->with('success', 'Data berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal update dosen: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui data.');
        }
    }

    /**
     * Hapus personel
     */
    public function destroy(Lecturer $lecturer)
    {
        DB::beginTransaction();

        try {

            if (
                $lecturer->image &&
                Storage::disk('public')->exists($lecturer->image)
            ) {
                Storage::disk('public')->delete($lecturer->image);
            }

            $lecturer->delete();

            DB::commit();

            return redirect()
                ->route('lecturers.index')
                ->with('success', 'Data dosen/staff berhasil dihapus.');

        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Gagal menghapus dosen', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->route('lecturers.index')
                ->with('error', 'Data gagal dihapus.');
        }
    }

    public function structure()
    {
        $pimpinan = Lecturer::whereNull('parent_id')
            ->with('subordinates')
            ->get();

        return view('admin.lecturer.structure', compact('pimpinan'));
    }
}