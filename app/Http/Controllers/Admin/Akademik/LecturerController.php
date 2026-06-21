<?php

namespace App\Http\Controllers\Admin\Akademik;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Class LecturerController
 * 
 * Mengelola data dosen dan tenaga kependidikan (staff), termasuk
 * riwayat pendidikan, struktur organisasi (organogram), dan fitur CRUD.
 */
class LecturerController extends Controller
{
    /**
     * Menampilkan daftar dosen/staff dengan filter pencarian dan tipe.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Lecturer::with('leader');

        // Filter pencarian (nama atau NIP/NIDN)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nip_nidn', 'like', "%{$search}%");
            });
        }

        // Filter tipe: dosen atau staff berdasarkan jabatan akademik
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
     * Menampilkan form tambah dosen/staff baru.
     * Menyediakan pilihan atasan untuk struktur organisasi.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Ambil data dosen/staff lain untuk pilihan atasan langsung
        $leaders = Lecturer::orderBy('name', 'asc')->get();
        return view('admin.lecturer.create', compact('leaders'));
    }

    /**
     * Menyimpan data dosen/staff beserta riwayat pendidikan.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip_nidn'           => 'nullable|unique:lecturers,nip_nidn',
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|unique:lecturers,email',
            'academic_position'  => 'required',
            'sinta_url'          => 'nullable|url',
            'pddikti_url'        => 'nullable|url',
            'image'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'degree.*'           => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['nip_nidn'] = $request->nip_nidn ?: null;
            $data['active']      = $request->boolean('active');
            $data['created_by']  = Auth::id();
            $data['parent_id']   = $request->parent_id ?: null; // null jika tidak ada atasan

            // Upload foto profil jika ada
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('lecturers', 'public');
            }

            $lecturer = Lecturer::create($data);

            // Simpan riwayat pendidikan (jika ada)
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
     * Menampilkan form edit dosen/staff.
     *
     * @param Lecturer $lecturer
     * @return \Illuminate\View\View
     */
    public function edit(Lecturer $lecturer)
    {
        // Pastikan relasi educations di-load
        $lecturer->load('educations');

        // Ambil daftar atasan potensial (kecuali dirinya sendiri)
        $leaders = Lecturer::where('id', '!=', $lecturer->id)
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.lecturer.edit', compact('lecturer', 'leaders'));
    }

    /**
     * Memperbarui data dosen/staff beserta riwayat pendidikan.
     *
     * @param Request $request
     * @param Lecturer $lecturer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        $request->validate([
            'nip_nidn'           => 'nullable|unique:lecturers,nip_nidn,' . $lecturer->id,
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|unique:lecturers,email,' . $lecturer->id,
            'academic_position'  => 'required',
            'sinta_url'          => 'nullable|url',
            'pddikti_url'        => 'nullable|url',
            'image'              => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['nip_nidn'] = $request->nip_nidn ?: null;
            $data['active']      = $request->boolean('active');
            $data['updated_by']  = Auth::id();
            $data['parent_id']   = $request->parent_id ?: null;

            // Proses unggah gambar baru (hapus gambar lama jika ada)
            if ($request->hasFile('image')) {
                if ($lecturer->image && Storage::disk('public')->exists($lecturer->image)) {
                    Storage::disk('public')->delete($lecturer->image);
                }
                $data['image'] = $request->file('image')->store('lecturers', 'public');
            }

            $lecturer->update($data);

            // Update riwayat pendidikan: hapus lama, simpan baru
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
     * Menghapus dosen/staff beserta file foto dan riwayat pendidikan.
     *
     * @param Lecturer $lecturer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Lecturer $lecturer)
    {
        DB::beginTransaction();

        try {
            // Hapus foto jika ada
            if ($lecturer->image && Storage::disk('public')->exists($lecturer->image)) {
                Storage::disk('public')->delete($lecturer->image);
            }

            // Hapus riwayat pendidikan (opsional jika cascade sudah diatur)
            $lecturer->educations()->delete();

            $lecturer->delete();

            DB::commit();

            return redirect()
                ->route('lecturers.index')
                ->with('success', 'Data dosen/staff berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Gagal menghapus dosen', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return redirect()
                ->route('lecturers.index')
                ->with('error', 'Data gagal dihapus.');
        }
    }

    /**
     * Menampilkan struktur organisasi (organogram) berbasis relasi parent-child.
     *
     * @return \Illuminate\View\View
     */
    public function structure()
    {
        // Ambil pimpinan (yang tidak memiliki atasan) beserta seluruh bawahan secara rekursif
        $pimpinan = Lecturer::whereNull('parent_id')
            ->with('subordinates')
            ->get();

        return view('admin.lecturer.structure', compact('pimpinan'));
    }
}